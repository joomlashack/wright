<?php
/**
 * @version   1.x
 * @package   ShackSlides
 * @copyright (C) 2010 Joomlashack / Meritage Assets Corp
 * @license   GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
/**
 *    This file is part of ShackSlides.
 *    
 *    ShackSlides is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with ShackSlides.  If not, see <http://www.gnu.org/licenses/>.
 *
 * */

defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addScript(JURI::base() . 'modules/mod_shackslides/assets/sliderman.js');
$app = JFactory::getApplication();
$doc->addStylesheet(JURI::base() . 'templates/'.$app->getTemplate().'/html/mod_shackslides/css/sliderman.css');

// This can be used in an override to change default settings. User can override
// settings in the module settings page still.
$defaults = array(
	'display_width' => '500', // width of container
	'display_height' => '250', // height of container
	'display_autoplay' => '5', // if not false, number of seconds per slide on autoplay
	'display_pause' => 'true', // pauses the autoplay on hover over slider
	'display_description' => 'true', // displays image discription box
	'display_buttons' => 'false', // displays the next/prev buttons
	'display_buttons_background' => '#ffffff', // buttons background color hex code
	'display_navigation' => 'true', // displays the navigation
	'display_navigation_buttons' => 'true', // displays next/prev buttons in navigation bar
	'display_mousewheel' => 'false', // can use mousewheel for navigation
	'display_container' => 'slider', // id for the slider container
	'display_navigation_container' => 'sliderNav', // id for the slider navigation container
);

?>

<div class="shackSlider">

	<div id="slider">
<?php for ($i = 0; $i < count($images); $i++) : ?>
<?php if ($links[$i]) : ?><a href="<?php echo $links[$i]; ?>"><?php endif; ?>
					<img src="<?php echo $base.$images[$i] ?>" title="<?php echo $titles[$i] ?>" />
		<?php if ($links[$i]) : ?></a><?php endif; ?>
		<?php if ($titles[$i]) : ?>
				<div class="slideTitle">
			<?php echo $titles[$i]; ?>
			</div>
<?php endif; ?>
			<?php endfor; ?>

	</div>
	<div id="sliderNav"></div>

<?php require(JPATH_BASE.DS.'modules'.DS.'mod_shackslides'.DS.'assets'.DS.'script.js.php') ?>

</div>
