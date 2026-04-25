<?php

namespace Modules\Upcertify\Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Upcertify\Models\Media;
use Illuminate\Support\Facades\Storage;
use Modules\Upcertify\Models\Template;

class UpcertifyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Media::truncate();
        $media = [


            [
                'title' => 'Default background-1',
                'path' => 'upcertify/media/img-01.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-2',
                'path' => 'upcertify/media/img-02.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-3',
                'path' => 'upcertify/media/img-03.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-4',
                'path' => 'upcertify/media/img-04.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-05.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-06.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-07.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-08.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-09.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-10.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/media/img-11.png',
                'type' => Media::TYPE['media'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-1',
                'path' => 'upcertify/backgrounds/background-1.png',
                'type' => Media::TYPE['pattern'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-2',
                'path' => 'upcertify/backgrounds/background-2.png',
                'type' => Media::TYPE['pattern'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-3',
                'path' => 'upcertify/backgrounds/background-3.png',
                'type' => Media::TYPE['pattern'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-4',
                'path' => 'upcertify/backgrounds/background-4.png',
                'type' => Media::TYPE['pattern'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default background-5',
                'path' => 'upcertify/backgrounds/background-5.png',
                'type' => Media::TYPE['pattern'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-1',
                'path' => 'upcertify/attachments/attachment-1.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-2',
                'path' => 'upcertify/attachments/attachment-2.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-3',
                'path' => 'upcertify/attachments/attachment-3.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-4',
                'path' => 'upcertify/attachments/attachment-4.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-5',
                'path' => 'upcertify/attachments/attachment-5.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-6',
                'path' => 'upcertify/attachments/attachment-6.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-7',
                'path' => 'upcertify/attachments/attachment-7.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-8',
                'path' => 'upcertify/attachments/attachment-8.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-9',
                'path' => 'upcertify/attachments/attachment-9.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Default attachment-10',
                'path' => 'upcertify/attachments/attachment-10.png',
                'type' => Media::TYPE['attachment'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Media::insert($media);
        $this->storeMedia($media, 'media');
        $this->generateTemplates();
    }

    public function generateTemplates()
    {
        Template::truncate();
        $templates = [
            [
                'title' => 'Certificate-1',
                'body' => json_encode([
                    "elementsInfo" => [
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-6.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 103.976px; top: 607.76px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-7.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 520.226px; top: 628.976px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220); position: absolute; cursor: move; transform: rotate(0rad); left: 929.132px; top: 675.191px;",
                            "wildcardName" => "issue_date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 648.993px;width: 127.896px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220); position: absolute; cursor: move; transform: rotate(0rad); left: 65.9896px; top: 675.198px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Project Supervisor",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 648.997px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Cameron",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 497.198px;width: 998px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "We congratulate you on this well-deserved success and wish you continued excellence in your future endeavors.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 470.99px;width: 981px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Your dedication, hard work, and determination have significantly contributed to this remarkable achievement.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 298.184px;top: 374.382px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "has successfully demonstrated outstanding performance and commitment in",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(0, 0, 0); position: absolute; cursor: move; transform: rotate(0rad); left: 472.969px; top: 323.177px; width: 300.469px; font-size: 36px; font-family: \"Noto Serif Georgian\";",
                            "wildcardName" => "student_name",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220); position: absolute; cursor: move; transform: rotate(0rad); left: 520.226px; top: 296.969px; font-family: \"Noto Sans Georgian\"; width: 205.479px; font-size: 18px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "This is to certify that",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220);position: absolute;cursor: move;transform: rotate(0rad);left: 493.201px;top: 141.285px;font-family: Playfair;font-size: 28px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "OF ACHIEVEMENT",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(155, 184, 220); position: absolute; cursor: move; transform: rotate(0rad); left: 520.243px; top: 103.212px; font-size: 28px; font-family: Playfair;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "CERTIFICATE",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-1.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 472.986px; top: 200.399px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-3.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 473px; top: 67px;",
                            "wildcardName" => "attachment",
                        ],
                    ],
                    "fontFamilies" => ["Noto Serif Georgian", "Noto Sans Georgian", "Playfair", "Playfair"],
                    "backgroundImage" => asset("storage/upcertify/backgrounds/background-3.png"),
                ]),
                'thumbnail_url' => 'upcertify/templates/certificate-1.png',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Certificate-2',
                'body' => json_encode([
                    "elementsInfo" => [
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-5.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 124.976px; top: 596.753px; color: rgb(0, 0, 0); width: 125.33px; height: 52.2222px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-2.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 491.233px; top: 224.378px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-4.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 491.233px; top: 83.9757px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-7.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 540.965px; top: 619.167px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 675.191px;",
                            "wildcardName" => "issue_date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 648.993px;width: 127.896px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 65.9896px;top: 675.198px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Project Supervisor",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 648.997px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Cameron",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 497.198px;width: 998px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "We congratulate you on this well-deserved success and wish you continued excellence in your future endeavors.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 470.99px;width: 981px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Your dedication, hard work, and determination have significantly contributed to this remarkable achievement.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 298.184px;top: 374.382px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "has successfully demonstrated outstanding performance and commitment in",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(0, 0, 0); position: absolute; cursor: move; transform: rotate(0rad); left: 472.969px; top: 323.177px; width: 300.469px; font-size: 36px; font-family: \"Noto Serif Georgian\";",
                            "wildcardName" => "student_name",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 520.226px;top: 296.969px;font-family: \"Noto Sans Georgian\";width: 205.479px;font-size: 18px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "This is to certify that",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 483.969px;top: 164.306px;font-family: Playfair;font-size: 28px;width: 250.354px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "OF ACHIEVEMENT",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(212 166 54);position: absolute;cursor: move;transform: rotate(0rad);left: 491.233px;top: 132.212px;font-size: 28px;font-family: Playfair;width: 225.417px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "CERTIFICATE",
                        ],
                    ],
                    "fontFamilies" => ["Noto Serif Georgian", "Noto Sans Georgian", "Playfair", "Playfair"],
                    "backgroundImage" => asset("storage/upcertify/backgrounds/background-5.png"),
                ]),
                'thumbnail_url' => 'upcertify/templates/certificate-2.png',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Certificate-3',
                'body' => json_encode([
                    "elementsInfo" => [
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-5.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 103.976px; top: 579.76px; color: rgb(0, 0, 0); width: 167.17px; height: 69.2153px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-10.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 472.969px; top: 200.382px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-7.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 539.979px; top: 648.976px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 675.191px;",
                            "wildcardName" => "issue_date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 648.993px;width: 127.896px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 65.9896px;top: 675.198px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Project Supervisor",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 648.997px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Cameron",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 497.198px;width: 998px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "We congratulate you on this well-deserved success and wish you continued excellence in your future endeavors.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 103.976px;top: 470.99px;width: 981px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Your dedication, hard work, and determination have significantly contributed to this remarkable achievement.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 298.184px;top: 374.382px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "has successfully demonstrated outstanding performance and commitment in",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(0, 0, 0); position: absolute; cursor: move; transform: rotate(0rad); left: 472.969px; top: 323.177px; width: 300.469px; font-size: 36px; font-family: \"Noto Serif Georgian\";",
                            "wildcardName" => "student_name",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 520.226px;top: 296.969px;font-family: \"Noto Sans Georgian\";width: 205.479px;font-size: 18px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "This is to certify that",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 493.201px;top: 141.285px;font-family: Playfair;font-size: 28px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "OF ACHIEVEMENT",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 520.243px; top: 103.212px; font-size: 28px; font-family: Playfair;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "CERTIFICATE",
                        ],
                    ],
                    "fontFamilies" => ["Noto Serif Georgian", "Noto Sans Georgian", "Playfair", "Playfair"],
                    "backgroundImage" => asset("storage/upcertify/backgrounds/background-2.png"),
                ]),
                'thumbnail_url' => 'upcertify/templates/certificate-3.png',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Certificate-4',
                'body' => json_encode([
                    "elementsInfo" => [
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-9.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 493.195px; top: 202.378px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-5.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 125.976px; top: 579.774px; color: rgb(0, 0, 0); width: 167.17px; height: 69.2153px;",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "ne, se, sw, nw",
                            "attachment" => asset("storage/upcertify/attachments/attachment-7.png"),
                            "inlineStyle" => "position: absolute; cursor: move; transform: rotate(0rad); left: 547.965px; top: 619.167px; color: rgb(0, 0, 0);",
                            "wildcardName" => "attachment",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 675.191px;",
                            "wildcardName" => "issue_date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 929.132px;top: 648.993px;width: 127.896px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Date",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 96.563px; top: 675.191px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Project Supervisor",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 126.976px; top: 648.976px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Cameron",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 96.5625px; top: 477.174px; width: 1007.95px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "We congratulate you on this well-deserved success and wish you continued excellence in your future endeavors.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "ui-draggable", "ui-draggable-handle", "ui-resizable", "uc-alignment-center"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 125.972px; top: 451.979px; width: 945.99px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "Your dedication, hard work, and determination have significantly contributed to this remarkable achievement.",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 298.184px;top: 374.382px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "has successfully demonstrated outstanding performance and commitment in",
                        ],
                        [
                            "actions" => "delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(222, 189, 56); position: absolute; cursor: move; transform: rotate(0rad); left: 472.969px; top: 323.177px; width: 300.469px; font-size: 36px; font-family: \"Noto Serif Georgian\";",
                            "wildcardName" => "student_name",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 520.226px;top: 296.969px;font-family: \"Noto Sans Georgian\";width: 205.479px;font-size: 18px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "This is to certify that",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150);position: absolute;cursor: move;transform: rotate(0rad);left: 493.201px;top: 141.285px;font-family: Playfair;font-size: 28px;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "OF ACHIEVEMENT",
                        ],
                        [
                            "actions" => "edit, delete, copy",
                            "classes" => ["uc-element-wildcard", "uc-alignment-left", "ui-draggable", "ui-draggable-handle", "ui-resizable"],
                            "handles" => "e, w",
                            "inlineStyle" => "color: rgb(76, 109, 150); position: absolute; cursor: move; transform: rotate(0rad); left: 520.243px; top: 103.212px; font-size: 28px; font-family: Playfair;",
                            "wildcardName" => "custom_message",
                            "custom_message" => "CERTIFICATE",
                        ],
                    ],
                    "fontFamilies" => ["Noto Serif Georgian", "Noto Sans Georgian", "Playfair", "Playfair"],
                    "backgroundImage" => asset("storage/upcertify/backgrounds/background-1.png"),
                ]),
                'thumbnail_url' => 'upcertify/templates/certificate-4.png',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        Template::insert($templates);
        $this->storeMedia($templates, 'templates');
    }

    private function storeMedia($media, $type)
    {
        foreach ($media as $item) {
            $media_path = $type == 'templates' ? $item['thumbnail_url'] : $item['path'];
            $path = str_replace('upcertify/', '', $media_path);
            $imagePath = 'modules/upcertify/demo-content/' . $path;
            if (file_exists(public_path($imagePath))) {
                Storage::disk(getStorageDisk())->put(
                    $media_path,
                    file_get_contents(public_path($imagePath))
                );
            }
        }
    }
}
