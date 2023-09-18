<?php
if (!function_exists('renderQuesAndAns')) {
    function renderQuesAndAns($text, $imageCodeArr = [])
    {
//        $text = preg_replace("/</", "&lt;", $text);
//
//        $text = preg_replace("/>/", "&gt;", $text);

        $regImageCode = '/\[anh\d+\]/';

        preg_match_all($regImageCode, $text, $matches);
        $imgCodeColArr = array_column($imageCodeArr, 'img_code');
        if (!empty($matches[0])) {
            foreach ($matches[0] as $item) {
                $imgCode = trim($item, '[]');

                $key = array_search($imgCode, $imgCodeColArr);
                if ($key === false) continue;
                $img = $imageCodeArr[$key];
                $text = str_replace($item, "<div class='p-2'><img class='w-75' src='{$img['path']}' /></div>", $text);
            }
        }
        return $text;
    }
}
//if (!function_exists('convert_formula')) {
//    function convert_formula($formula) {
//        // Thay thế các dấu chấm bằng dấu nhân
//        $formula = str_replace(".", "\\times", $formula);
//        // Thay thế các dấu phẩy bằng dấu chấm
//        $formula = str_replace(",", ".", $formula);
//        // Thay thế các dấu 〖 bằng \\left[
//        $formula = str_replace("〖", "\\left[", $formula);
//        // Thay thế các dấu 〗 bằng \\right]
//        $formula = str_replace("〗", "\\right]", $formula);
//        // Thay thế các dấu ⁡ bằng dấu cách
//        $formula = str_replace("⁡", " ", $formula);
//        // Trả về công thức đã được chuyển đổi
//        $formula = str_replace(".", "\\times", $formula);
//        // Thay thế các dấu phẩy bằng dấu chấm
//        $formula = str_replace(",", ".", $formula);
//        // Thay thế các dấu 〖 bằng \\left[
//        $formula = str_replace("〖", "\\left[", $formula);
//        // Thay thế các dấu 〗 bằng \\right]
//        $formula = str_replace("〗", "\\right]", $formula);
//        // Thay thế các dấu ⁡ bằng dấu cách
//        $formula = str_replace("⁡", " ", $formula);
//        // Thay thế các dấu √ bằng \\sqrt
//        $formula = str_replace("√", "\\sqrt", $formula);
//        // Thay thế các dấu ∫ bằng \\int
//        $formula = str_replace("∫", "\\int", $formula);
//        // Thay thế các dấu ▒ bằng dấu cách
//        $formula = str_replace("▒", " ", $formula);
//        // Thay thế các dấu _ bằng dấu cách và đặt giới hạn tích phân trong ngoặc nhọn
//        $formula = preg_replace("/_(\\S+)\\^(\\S+)/", "_{$1}^{$2}", $formula);
//  // Trả về công thức đã được chuyển đổi
//  return $formula;
//    }
//}
