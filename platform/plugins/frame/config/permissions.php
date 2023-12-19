<?php

return [
    [
        'name' => 'Frame',
        'flag' => 'frame.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'frame.create',
        'parent_flag' => 'frame.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'frame.edit',
        'parent_flag' => 'frame.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'frame.destroy',
        'parent_flag' => 'frame.index',
    ],
];