<?php
if (!function_exists('renderQuesAndAns')) {
    function renderQuesAndAns($text, $imageCodeArr = [], $imgWidth = 75)
    {
        $text = preg_replace("/</", "&lt;", $text);

        $text = preg_replace("/>/", "&gt;", $text);

        $regImageCode = '/\[anh\d+\]/';

        preg_match_all($regImageCode, $text, $matches);
        $imgCodeColArr = array_column($imageCodeArr, 'img_code');
        if (!empty($matches[0])) {
            foreach ($matches[0] as $item) {
                $imgCode = trim($item, '[]');

                $key = array_search($imgCode, $imgCodeColArr);
                if ($key === false) continue;
                $img = $imageCodeArr[$key];
                $text = str_replace($item, "<div class='p-2'><img class='w-" . $imgWidth . "' src='{$img['path']}' /></div>", $text);
            }
        }
        return $text;
    }
}

if (!function_exists('checkTime')) {
    function checkTime($poetry = null, $examinations = null): bool
    {
        if (!$poetry) return false;
        if (!$examinations) {
            $examinations = \App\Models\examination::all();
        }
        $now = now();
        $examination = $examinations->where('id', $poetry->start_examination_id)->first();
        $time = \Illuminate\Support\Carbon::parse($poetry->exam_date . ' ' . $examination->started_at);
        if ($now->greaterThan($time)) {
            return true;
        }
        return false;
    }
}
