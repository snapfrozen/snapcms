<?php

/**
 * Add or override backend configuration here
 */
return array(
    'components' => array(
        'db' => require('../../db.php'),
        'user' => array(
            'allowAutoLogin' => true
        )
    )
);
