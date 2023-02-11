<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Helpers
{
    public static function cacheUpdate($userId, $data, $cache_key)
    {
        if (Helpers::cacheHas($cache_key)) {
            Helpers::cacheDelete($cache_key);
        }
        Helpers::cacheForever($cache_key, [
            'user_id' => $userId,
            'data' => $data,
        ]);
    }

    public static function cachePut($key, $value)
    {
        if (env('CACHE_ACTIVE')) {
            Cache::put($key,serialize($value),now()->addMinutes(30));
        }
    }

    public static function cacheDelete($key)
    {
        if (env('CACHE_ACTIVE')) {
            Cache::forget('$key');
        }
    }

    public static function cacheHas($key)
    {
        if (Cache::has($key) && env('CACHE_ACTIVE')) {
            return true;
        } else {
            return false;
        }
    }

    public static function cacheGet($key)
    {
        return unserialize(Cache::get($key));
    }

    public static function cacheForever($key, $value)
    {
        if (env('CACHE_ACTIVE')) {
            Cache::forever($key, serialize($value));
        }

    }

    public static function direction($direction)
    {
        return ($direction == "buy") ? 1 : 0;
    }

    /**
     * Convert comma separated values to array
     *
     * @param $string_value
     * @return array
     */
    public static function stringToArray($string_value)
    {
        $static_values = explode(',', $string_value);

        return array_map(function ($val) {
            return str_replace('\r', '', str_replace('\n', '', trim($val)));
        }, $static_values);
    }

    public static function repeatChar($repeat_count, $char = '-', $space = ' ')
    {
        $output = '';
        if ($repeat_count > 0) {
            for ($i = $repeat_count; $i >= 0; $i--) {
                $output = $output . $char;
            }
        }

        return $output . $space;

    }

    public static function stringToSecret(string $string = NULL)
    {
        if (!$string) {
            return NULL;
        }
        $length = strlen($string);
        $visibleCount = (int)round($length / 4);
        $hiddenCount = $length - ($visibleCount * 2);
        return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
    }

    public static function paymentStatus($status, $html_class = null)
    {
        // 0 bekliyor, 1 Ödendi, 2 Cüzdana işlendi, 3 İptal
        switch ($status) {
            case 0:
                $val = ['class' => 'badge-primary', 'message' => 'Bekliyor'];
                break;
            case 1:
                $val = ['class' => 'badge-success', 'message' => 'Ödendi'];
                break;

            case 2:
                $val = ['class' => 'badge-warning', 'message' => 'Cüzdana İşlendi'];
                break;

            case 3:
                $val = ['class' => 'badge-danger', 'message' => 'İptal'];
                break;
        }

        if ($html_class != null) {
            $val['class'] = $val['class'] . ' ' . $html_class;
        }

        return '<span class="badge ' . $val['class'] . '">' . $val['message'] . '</span>';
    }

    public static function seperator($word = 'VEYA')
    {
        return '<div class="row m-0 p-0" id="seperator">
                <div class="col-5 m-0 p-0"><hr></div>
                <div class="col-3 m-0 p-0 text-center">' . $word . '</div>
                <div class="col-4 m-0 p-0"><hr></div>
            </div>';
    }

    public static function badgeStatus($status)
    {
        // 0 bekliyor, 1 Ödendi, 2 Cüzdana işlendi, 3 İptal
        switch ($status) {
            case 0:
                $val = ['class' => 'badge-warning', 'message' => 'Kapalı'];
                break;
            case 1:
                $val = ['class' => 'badge-success', 'message' => 'Açık'];
                break;
        }

        return '<span class="badge ' . $val['class'] . '">' . $val['message'] . '</span>';
    }

    public static function paymentType($status)
    {
        // 0 yatırım, 1 çekim
        switch ($status) {
            case 0:
                $val = ['class' => 'badge-warning', 'message' => 'Çekim'];
                break;
            case 1:
                $val = ['class' => 'badge-success', 'message' => 'Yatırım'];
                break;
        }

        return '<span class="badge ' . $val['class'] . '">' . $val['message'] . '</span>';
    }

    public static function userAgent()
    {
        $agents = [
            #Chrome
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (Windows NT 5.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
            #Firefox
            'Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1)',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)',
            'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (Windows NT 6.2; WOW64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64; Trident/7.0; rv:11.0) like Gecko',
            'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)',
            'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)'
        ];

        return Arr::random($agents);
    }

    public static function randomName($card_owner = null)
    {
        $card_owner = str_replace('  ', ' ', $card_owner);
        $co = explode(' ', trim($card_owner));
        $count = count($co);
        $firstname = "";
        $lastname = "";
        if ($count == 2) {
            $firstname = $co[0];
            $lastname = $co[1];
        } else if ($count > 2) {
            $firstname = $co[0] . ' ' . $co[1];
            $lastname = $co[2];
        }

        return array('name' => $firstname, 'surname' => $lastname);
    }

    public static function nameSplitter($name)
    {
        $nameArr = [];
        if (strstr($name, ' ')) {
            $nameExp = explode(' ', $name);
            if (count($nameExp) <= 2) {
                $nameArr = ['first_name' => $nameExp[0], 'last_name' => $nameExp[1]];
            } else {
                $last_name = last($nameExp);
                unset($nameExp[count($nameArr) - 1]);
                $nameArr = ['first_name' => implode($nameArr), 'last_name' => $last_name];
            }
        } else {
            $nameArr = ['first_name' => $name, 'last_name' => ''];
        }

        return $nameArr;
    }

}
