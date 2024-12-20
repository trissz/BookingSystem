<?php
    /* ********************************************************
	 * ********************************************************
	 * ********************************************************/
    class ApartmentImageFileBo {
        const ORIGINAL_FILE_REPRESENTER               = 'original';
        const ORIGINAL_PNG_CONVERTED_FILE_REPRESENTER = 'original_png';
        
        const CONVERTED_FILE_REPRESENTER_ICON         = 'icon';
        const CONVERTED_FILE_REPRESENTER_SMALL        = 'small';
        const CONVERTED_FILE_REPRESENTER_MEDIUM       = 'medium';
        const CONVERTED_FILE_REPRESENTER_LARGE        = 'large';

        const FILE_EXTENSION_JPG                      = 'jpg';
        const FILE_EXTENSION_JPEG                     = 'jpeg';
        const FILE_EXTENSION_PNG                      = 'png';
        const FILE_EXTENSION_GIF                      = 'gif';
        const FILE_EXTENSION_BMP                      = 'bmp';

        const TRASFORMATION_CROP_AND_RESIZE  = 'crop_and_resize';
        const TRASFORMATION_RESIZE_TO_WIDTH  = 'resize_to_width';
        const TRASFORMATION_RESIZE_TO_HEIGTH = 'resize_to_heigth';

        public $do;
        public $file_input;

        public $target_directory = 'cdn/user_profile_pictures';
        public $acceptable_file_extensions = [
            self::FILE_EXTENSION_JPG,
            self::FILE_EXTENSION_JPEG,
            self::FILE_EXTENSION_PNG,
            self::FILE_EXTENSION_GIF,
            self::FILE_EXTENSION_BMP
        ];
        public $is_file_input_valid = false;
        public $file_extension;
        public $original_cdn_file_path;
        public $original_png_cdn_file_path;
        public $original_image_size_width;
        public $original_image_size_height;
        public $original_image_aspect_ratio;
        public $messages = [];

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function __construct($file_input, $do) {
            $this->file_input = $file_input;
            $this->do = $do;
			
			//Set the target directory
			$this->target_directory = RequestHelper::$common_file_root . 'cdn/apartment_images/';

            //Get the uploaded files extension
            $this->file_extension = strtolower(pathinfo(
                basename($file_input['name']),
                PATHINFO_EXTENSION
            ));
            
            //Create a path for the original uploaded file
            $this->original_cdn_file_path = $this->getOriginalFilePath($this->file_extension);
            //Create a path for the original converted PNG file
            //(PNG in order to utilize the transparent background)
            $this->original_png_cdn_file_path = $this->getOriginalPNGConvertedFilePath();

            //Check if file type acceptable
            if ($this->isFileTypeAcceptable()) {
                //Retrieve the uploaded image files width and height
                $this->original_image_size_width = getimagesize($this->file_input['tmp_name'])[0];
                $this->original_image_size_height = getimagesize($this->file_input['tmp_name'])[1];
                //Retrieve the uploaded image files aspect ratio
                $this->original_image_aspect_ratio = (
                    $this->original_image_size_width /
                    $this->original_image_size_height
                );
                //Remove the original image file in case we want to replace it
                $this->removeOriginalIfExists();
                //Move original the original image file to the CDN
                $this->moveToCDN();
                //Create a PNG file from the original uploaded image file
                $this->convertToPNG(
                    $this->original_cdn_file_path,
                    $this->original_png_cdn_file_path
                );

                //Create appropriate resized and cropped images files from PNG source
                $this->createImageVerions();
            }
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function getOriginalFilePath($file_extension) {
            return $this->target_directory . 
                $this->do->class_actor . '_' . 
                $this->do->id . '_' .
                self::ORIGINAL_FILE_REPRESENTER . '.' .
                $file_extension;
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function getOriginalPNGConvertedFilePath() {
            return $this->target_directory . 
                $this->do->class_actor . '_' . 
                $this->do->id . '_' .
                self::ORIGINAL_PNG_CONVERTED_FILE_REPRESENTER . '.' .
                self::FILE_EXTENSION_PNG;
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function getConvertedFilePath(string $result_file_variable) {
            return $this->target_directory . 
                $this->do->class_actor . '_' . 
                $this->do->id . '_' .
                $result_file_variable . '.' .
                self::FILE_EXTENSION_PNG;
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function isFileTypeAcceptable() {
            if (in_array($this->file_extension, $this->acceptable_file_extensions)) {
                $this->is_file_input_valid = true;
                $this->messages[] = 'File type ok';

                return true;
            }
            else {
                $this->is_file_input_valid = false;
                $this->messages[] = 'File type not supported: ' . $this->file_extension;

                return false;
            }

            return false;
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function removeOriginalIfExists() {
            foreach($this->acceptable_file_extensions as $file_extension) {
                $original_cdn_file_path = $this->getOriginalFilePath($file_extension);

                if (file_exists($original_cdn_file_path)) {
                    if(unlink($original_cdn_file_path)) {
                        $this->messages[] = 'Removed original file: ' . $original_cdn_file_path;
                    }
                    else {
                        $this->messages[] = 'Was not able to delete file: ' . $original_cdn_file_path;
                    }
                }
                else {
                    $this->messages[] = 'No original file found: ' . $original_cdn_file_path;
                }
            }
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function removeFileIfExists($file_path) {
            if (file_exists($file_path)) {
                if(unlink($file_path)) {
                    $this->messages[] = 'Removed file: ' . $file_path;
                }
                else {
                    $this->messages[] = 'Was not able to delete file: ' . $file_path;
                }
            }
            else {
                $this->messages[] = 'No file found: ' . $file_path;
            }
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function moveToCDN() {
            rename(
                $this->file_input['tmp_name'],
                $this->original_cdn_file_path
            );
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function convertToPNG(
            $source_path,
            $destination_path,
            $quality = 9
        ) {
            $source_file_extension = strtolower(pathinfo(
                basename($source_path),
                PATHINFO_EXTENSION
            ));

            switch ($source_file_extension) {
                case self::FILE_EXTENSION_JPG:
                case self::FILE_EXTENSION_JPEG:
                    $graphic_draw_image = imagecreatefromjpeg($source_path);
                    break;
                case self::FILE_EXTENSION_PNG:
                    $graphic_draw_image = imagecreatetruecolor(
                        $this->original_image_size_width,
                        $this->original_image_size_height
                    );
                    $source_image = imagecreatefrompng($source_path);
                    $alpha_channel = imagecolorallocatealpha($graphic_draw_image, 0, 0, 0, 127);
                    imagecolortransparent($graphic_draw_image, $alpha_channel);
                    imagefill(
                        $graphic_draw_image,
                        0,
                        0,
                        $alpha_channel
                    );
                    imagecopy(
                        $graphic_draw_image,
                        $source_image,
                        0,
                        0,
                        0,
                        0,
                        $this->original_image_size_width,
                        $this->original_image_size_height
                    );
                    imagesavealpha($graphic_draw_image, true);

                    //$graphic_draw_image = imagecreatefrompng($source_path);
                    break;
                case self::FILE_EXTENSION_GIF:
                    $graphic_draw_image = imagecreatefromgif($source_path);
                    break;
                case self::FILE_EXTENSION_BMP:
                    $graphic_draw_image = imagecreatefrombmp($source_path);
                    break;
                default:
                    $this->messages[] = 'UnSupported image extension: ' . $source_file_extension;
            }

            imagepng($graphic_draw_image, $destination_path, $quality);
            imagedestroy($graphic_draw_image);
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function createImageVerions() {
            switch ($this->do->class_actor) {
                case strtolower(ActorHelper::USER):
                    $this->createBasicSquareImages();
                    break;
                default:
					$this->createBasicSquareImages();
                    //$this->messages[] = 'UnSupported actor: ' . $this->do->class_actor;
            }
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function createBasicSquareImages() {
            $image_versions = [
                [
                    'conversion_type'      => self::TRASFORMATION_CROP_AND_RESIZE,
                    'result_file_variable' => self::CONVERTED_FILE_REPRESENTER_ICON,
                    'width'                => 50,
                    'height'               => 50
                ],
                [
                    'conversion_type'      => self::TRASFORMATION_CROP_AND_RESIZE,
                    'result_file_variable' => self::CONVERTED_FILE_REPRESENTER_SMALL,
                    'width'                => 100,
                    'height'               => 100
                ],
                [
                    'conversion_type'      => self::TRASFORMATION_CROP_AND_RESIZE,
                    'result_file_variable' => self::CONVERTED_FILE_REPRESENTER_MEDIUM,
                    'width'                => 200,
                    'height'               => 200
                ],
                [
                    'conversion_type'      => self::TRASFORMATION_CROP_AND_RESIZE,
                    'result_file_variable' => self::CONVERTED_FILE_REPRESENTER_LARGE,
                    'width'                => 300,
                    'height'               => 300
                ],
            ];

            foreach ($image_versions as $image_version) {
                $this->cropAndResize(
                    $image_version['width'],
                    $image_version['height'],
                    $image_version['result_file_variable']
                );
            }
        }

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        protected function cropAndResize(
            int $width,
            int $height,
            string $result_file_variable
        ) {
			$this->removeFileIfExists($this->getConvertedFilePath($result_file_variable));
			
            $resized_width = 0;
            $resized_height = 0;
            if ($this->original_image_size_width <= $this->original_image_size_height) {
                $resized_width = $width;
                $resized_height = ($width / $this->original_image_aspect_ratio);
            }
            else {
                $resized_width = ($height * $this->original_image_aspect_ratio);
                $resized_height = $height;
            }

            $graphic_draw_image = imagecreatetruecolor($resized_width, $resized_height);
            imagealphablending($graphic_draw_image, false);
            imagesavealpha($graphic_draw_image, true);
            $tmp_graphic_draw_image = imagecreatefrompng($this->original_png_cdn_file_path);
            imagecopyresampled(
                $graphic_draw_image,
                $tmp_graphic_draw_image,
                0,
                0,
                0,
                0,
                $resized_width,
                $resized_height,
                $this->original_image_size_width,
                $this->original_image_size_height
            );

            imagepng(
                $graphic_draw_image,
                $this->getConvertedFilePath($result_file_variable),
                9
            );
        }
    }
?>