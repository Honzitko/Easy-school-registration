<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class ESR_Registration_Thank_You_Text_Helper {

	public function print_content($data) {
		$content = '<div id="esr-thank-you" class="esr-thank-you esr-courses">' . nl2br(stripcslashes(ESR()->settings->esr_get_option('thank_you_text'))) . '</div>';

		foreach (['registered', 'full', 'already_registered'] as $tag) {
			if (isset($data[$tag])) {
				$content = str_replace('[list_' . $tag . ']', $this->prepare_courses_list($data, $tag), $content);

				$content = str_replace('[' . $tag . '_exists]', '', $content);
				$content = str_replace('[/' . $tag . '_exists]', '', $content);
			} else {
				$content = preg_replace('/\[' . $tag . '_exists\].*\[\/' . $tag . '_exists\]/is', '', $content);
			}
		}

		return $content;
	}


	private function prepare_courses_list($data, $key) {
		$content = '';
		if (isset($data[$key])) {
			$content .= '<p class="esr-courses">';
			foreach ($data[$key] as $course_id => $course) {
				$course_data = ESR()->course->get_course_data($course_id);
				$content     .= '<span class="esr-name">' . $course_data->title . ' - ' . ESR()->day->get_day_title($course_data->day) . '</span><br>';
			}
			$content .= '</p>';
		}

		return $content;
	}

}