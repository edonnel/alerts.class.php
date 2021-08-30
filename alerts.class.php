<?
	class alerts {

			public static function push($text, $title = '', $type = 'alert', $redirect = false, $critical = false) {
				if (isset($_SESSION['ed_alerts']) && !is_array($_SESSION['ed_alerts']) || !isset($_SESSION['ed_alerts']))
					$_SESSION['ed_alerts'] = array();

				array_push($_SESSION['ed_alerts'], array(
					'text'      => $text,
					'title'     => $title,
					'type'      => $type,
					'critical'  => $critical,
				));

				if ($redirect) {
					if (!headers_sent())
						header('Location: '.$redirect);
					else
						echo '<script type="text/javascript">window.location="'.$redirect.'"</script>';

					die();
				}
			}

			public static function get($only_first = false) {
				$output = '';

				if (isset($_SESSION['ed_alerts']) && is_array($_SESSION['ed_alerts']) && count($_SESSION['ed_alerts']) > 0) {
					$output .= '<div class="ed-alerts">';

					foreach ($_SESSION['ed_alerts'] as $alert) {
						$output .= '<div class="ed-alert '.$alert['type'].'">';
						$output .= '<div class="fa fa-fw fa-close close" style="float:right; line-height:inherit; cursor:pointer;" onclick="RemoveEDAlert(this);"></div>';

						if ($alert['title'])
							$output .= '<div class="ed-alert-title">'.$alert['title'].'</div>';

						$output .= '<div class="ed-alert-text">'.$alert['text'].'</div>';
						$output .= '</div>';

						if ($only_first)
							break;
					}

					$output .= '</div>';

					$output .= '<script>function RemoveEDAlert(that){$(that).parent().slideUp();}</script>';

					unset($_SESSION['ed_alerts']);
				}

				return $output;
			}

			public static function are_critical() {
				if (isset($_SESSION['ed_alerts']) && $_SESSION['ed_alerts']) {
					foreach ($_SESSION['ed_alerts'] as $alert) {
						if (isset($alert['critical']) && $alert['critical'])
							return true;
					}
				}

				return false;
			}

		}
