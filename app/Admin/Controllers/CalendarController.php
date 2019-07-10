<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class CalendarController extends AdminController
{
    public function box(Content $content)
    {
        $content->title('Calendar');

        $content->body(view('admin.calendar'));

        return $content;
    }
}
