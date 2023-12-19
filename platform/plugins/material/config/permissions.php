<?php

return [
    [
        'name' => 'Material',
        'flag' => 'material.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'material.create',
        'parent_flag' => 'material.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'material.edit',
        'parent_flag' => 'material.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'material.destroy',
        'parent_flag' => 'material.index',
    ],
];