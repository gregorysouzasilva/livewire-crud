<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait TagTrait {

    //get all the tags between {} from a string
    public function getTags($string) {
        preg_match_all('/\{(.*?)\}/', $string, $matches);
        return $matches[1];
    }

    //replace all the tags between {} from a string
    public function replaceTags($string, $tags) {
        foreach ($tags as $tag) {
            $string = str_replace('{' . $tag . '}', $this->$tag ?? '', $string);
        }
        return $string;
    }

    public function renderTags($string) {
        $tags = $this->getTags($string);
        $string = $this->replaceTags($string, $tags);
        return $string;
    }

    public function evalTags($string) {
        $tags = $this->getTags($string);
        $string = $this->replaceTags($string, $tags);
        $string = empty($string) ? 'null' : $string;
        return eval('return ' . $string . ';');
    }

}