<?php
namespace App\icon_link;
class icon
{
    public static function FontAwesomeIcon($mime_type)
    {
        // List of official MIME Types: http://www.iana.org/assignments/media-types/media-types.xhtml
        static $font_awesome_file_icon_classes = [
            // Images
            'image'                                                                     => 'fa-file-image',
            // Audio
            'audio'                                                                     => 'fa-file-audio',
            // Video
            'video'                                                                     => 'fa-file-video',
            // Documents
            'application/pdf'                                                           => 'fa-file-pdf',
            'application/msword'                                                        => 'fa-file-word',
            'application/vnd.ms-word'                                                   => 'fa-file-word',
            'application/vnd.oasis.opendocument.text'                                   => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml'            => 'fa-file-word',
            'application/vnd.ms-excel'                                                  => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml'               => 'fa-file-excel',
            'application/vnd.oasis.opendocument.spreadsheet'                            => 'fa-file-excel',
            'application/vnd.ms-powerpoint'                                             => 'fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml'              => 'ffa-file-powerpoint',
            'application/vnd.oasis.opendocument.presentation'                           => 'fa-file-powerpoint',
            'text/plain'                                                                => 'fa-file-alt',
            'text/html'                                                                 => 'fa-file-code',
            'application/json'                                                          => 'fa-file-code',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
            // Archives
            'application/gzip'                                                          => 'fa-file-archive',
            'application/zip'                                                           => 'fa-file-archive',
            'application/x-zip-compressed'                                              => 'fa-file-archive',
            // Misc
            'application/octet-stream'                                                  => 'fa-file-archive',
        ];

        if (isset($font_awesome_file_icon_classes[$mime_type]))
            return $font_awesome_file_icon_classes[$mime_type];

        $mime_group = explode('/', $mime_type, 2)[0];
        return (isset($font_awesome_file_icon_classes[$mime_group])) ? $font_awesome_file_icon_classes[$mime_group] : 'fa-file';
    }
    //get from github
}