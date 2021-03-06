<?php

namespace Bokka\Utilities;

/**
 * Bokka\Utilities\Video
 * @version 0.0.1
 */
final class Video
{
    /**
     * Takes a YouTube or Vimeo URL and extracts the video ID
     * @param  string $url YouTube or Vimeo URL
     * @return string      Unique video ID
     */
    public static function getIDFromVideoURL($url)
    {
        $video_id = '';

        // YouTube URLs
        if (preg_match('/youtube/', $url, $id) || preg_match('/youtu\.be/', $url, $id)) {
            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
                $video_id = $id[1];
            } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
                $video_id = $id[1];
            } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
                $video_id = $id[1];
            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
                $video_id = $id[1];
            } elseif (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
                $video_id = $id[1];
            } else {
                return false;
            }
        } elseif (preg_match('/vimeo/', $url, $id)) {
            if (preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $id)) {
                $video_id = $id[5];
            } else {
                return false;
            }
        }

        return $video_id;
    }

    /**
     * Retrieves the video embed URL needed for CORS compatibility
     * @param  string $url Video URL
     * @return string      Video embed URL
     */
    public static function getEmbedURL($url)
    {
        $id = self::getIDFromVideoURL($url);

        if ($id) {
            if (strpos($url, 'youtube') || strpos($url, 'youtu.be')) {
                $url = 'https://www.youtube.com/embed/' . $id . '?autoplay=1';
            } elseif (strpos($url, 'vimeo')) {
                $url = 'https://player.vimeo.com/video/' . $id . '?autoplay=1';
            }
        } else {
            return false;
        }

        return $url;
    }
}
