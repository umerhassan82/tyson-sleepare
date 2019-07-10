<?php

namespace App\Admin\Controllers;

use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class WidgetsController extends Controller
{

    public function box(Content $content)
    {
        $content->title('Box container');

        $box1 = new Widgets\Box('First box', '<pre>Lorem ipsum dolor sit amet</pre>');
        $box2 = new Widgets\Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
        $box3 = new Widgets\Box('Third box');

        $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
        $rows = [
            [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
            [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
            [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
            [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
            [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
        ];
        $table = new Widgets\Table($headers, $rows);
        $box4 = new Widgets\Box('Forth Box', $table);

        $content->row($box1->collapsable());
        $content->row($box2->style('danger'));
        $content->row($box3->removable()->style('warning'));
        $content->row($box4->solid()->style('primary'));

        return $content;
    }
}
