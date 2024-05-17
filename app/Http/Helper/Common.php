<?php

use Intervention\Image\Facades\Image;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

if (!function_exists('uploadPlease')) {
    function uploadPlease($image)
    {

        $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->save('public/uploads/' . $imageName);
        return $img_url = 'public/uploads/' . $imageName;
        
    }
}


if (!function_exists('createSlug')) {
    function createSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
    
        return $slug;
    }
}

if (!function_exists('perform_seo')) {
    function perform_seo($seo)
    {
 
        OpenGraph::setTitle($seo->title)
            ->setDescription($seo->description)
            ->setType('article')
            ->setArticle([
                'published_time' => $seo->published_time,
                'modified_time' => $seo->modified_time,
                'expiration_time' => $seo->expiration_time,
                'author' => $seo->author,
                'section' => $seo->section,
                'tag' => [$seo->keywords]
            ]);



        SEOMeta::setTitle($seo->title);
        SEOMeta::setCanonical($seo->canonical);
        SEOMeta::setDescription($seo->description);
        SEOMeta::addKeyword([$seo->keywords]);

        OpenGraph::setDescription($seo->description);
        OpenGraph::setTitle($seo->title);
        OpenGraph::setUrl($seo->og_url);
        OpenGraph::addProperty('type', $seo->og_type);
        OpenGraph::addProperty('locale', $seo->og_locale);

        OpenGraph::addImage(['url' => $seo->image_url, 'size' => $seo->link_img_size]);
        OpenGraph::addImage(asset($seo->image), ['height' => $seo->image_height, 'width' => $seo->image_width]);

        TwitterCard::setTitle($seo->title);
        TwitterCard::setSite($seo->twitter_side);
        TwitterCard::addImage(asset($seo->image));
        TwitterCard::setDescription($seo->description);


        JsonLd::setTitle($seo->title);
        JsonLd::setDescription($seo->description);
        JsonLd::setType($seo->og_type);
        JsonLd::addImage(asset($seo->image));
        

        return 1;
    }

    
}

