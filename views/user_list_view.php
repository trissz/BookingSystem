<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class UserListView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
			?>
                <h1><?php print(RequestHelper::$actor_class_name); ?> list</h1>
<table>
    <thead>
        <tr>
            <?php

                foreach ($this->do->do_list[0]->getAttributes() as $key => $value) {
                    if (
                        $key !== 'content' &&
                        $value !== "" &&
                        $value !== null
                    ) {
                        print('<th>' . $key . '</th>');
                    }
                }
            ?>
        </tr>
    </thead>
    <tbody>
            <?php

                foreach ($this->do->do_list as $do) {
                    print('<tr>');
                        foreach ($do->getAttributes() as $key => $value) {
                            if (
                                $key !== 'content' &&
                                $value !== "" &&
                                $value !== null
                            ) {
                                if ($key === 'url') {
                                    print('<td><a href="' . $value . '" target="_blank">' . $value . '</a></td>');
                                }
                                else {
                                    print('<td>' . $value . '</td>');
                                }
                            }
                        }
                    print('</tr>');
                }
            ?>
    </tbody>
</table>
            <?php
        }

    }

?>