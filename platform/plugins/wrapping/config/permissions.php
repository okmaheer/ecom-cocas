<?php

return [
    [
        'name' => 'Wrapping',
        'flag' => 'wrapping.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'wrapping.create',
        'parent_flag' => 'wrapping.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'wrapping.edit',
        'parent_flag' => 'wrapping.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'wrapping.destroy',
        'parent_flag' => 'wrapping.index',
    ],
];