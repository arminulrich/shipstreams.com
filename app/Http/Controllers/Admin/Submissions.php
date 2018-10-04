<?php
namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use Bkwld\Decoy\Controllers\Base;

class Submissions extends Base
{
    protected $columns = [
        'Email' => 'getEmailAttribute',
        'Twitch Username' => 'getTwitchUsernameAttribute',
        'Twitter Handle' => 'getTwitterHandleAttribute',
        'Website' => 'getWebsiteAttribute',
        'Added?' => 'getAlreadyAddedAttribute'
    ];

    /*
     * Example settings

    protected $title = 'News & Events';

    protected $description = 'News and events yo!';

    protected $columns = [
        'Title' => 'getAdminTitleHtmlAttribute',
        'Status' => 'getAdminFeaturedAttribute',
        'Date' => 'created_at',
    ];
    protected $search = [
        'title',
        'featured' => [
            'type' => 'select',
            'label' => 'featured status',
            'options' => [
                1 => 'featured',
                0 => 'not featured',
            ]
        ],
        'category' => [
            'type' => 'select',
            'options' => 'App\Article::$categories',
        ],
        'date' => 'date',
    ];

     *
     */

    public function __construct()
    {
        $this->model = Submission::class;
        parent::__construct();
    }
}
