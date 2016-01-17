/**
 * Part of the Platform Default Frontend Theme.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform Theme Frontend Default
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       https://cartalyst.com
 */

var Platform;

;(function(window, document, $, undefined)
{

	'use strict';

	Platform = Platform || {
		App: {},
		Urls: {},
		Cache: {},
	};

	// Platform Base URL
	Platform.Urls.base = $('meta[name="base_url"]').attr('content');

	// CSRF on AJAX requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// Cache common selectors
	Platform.Cache.$win   = $(window);
	Platform.Cache.$body  = $(document.body);
	Platform.Cache.$alert = $('.alert');

	// Initialize functions
	Platform.App.init = function()
	{
		Platform.App
			.listeners()
			.validation()
			.replaceSVGs()
		;
	};

	// Add Listeners
	Platform.App.listeners = function()
	{
		Platform.Cache.$alert
			.on('click', '.close', Platform.App.closeAlerts)
		;

		return this;
	};

	// Initialize the form validation
	Platform.App.validation = function()
	{
		window.ParsleyConfig = {
			errorClass: 'has-error',
			successClass: 'has-success',
			classHandler: function (Field)
			{
				return Field.$element.parents('.form-group');
			},
			errorsContainer: function (Field)
			{
				return Field.$element.parents('.form-group');
			},
			errorsWrapper: '<span class=\"parsley-help-block\"></span>',
			errorTemplate: '<div></div>',
		};

		if ($('[data-parsley-validate]').length > 0)
		{
			$(document).ready(function()
			{
				$.listen('parsley:field:success', function(Field)
				{
					Field.$element.closest('.form-group').find('.help-block').show();
				});

				$.listen('parsley:field:error', function(Field)
				{
					Field.$element.closest('.form-group').find('.help-block').hide();
				});
			});
		}

		return this;
	};

	// Replace images with .svg class with in line svg
	Platform.App.replaceSVGs = function()
	{
		$('img.svg').each(function()
		{
			var $image     = $(this);
			var imageId    = $image.attr('id');
			var imageUrl   = $image.attr('src');
			var imageClass = $image.attr('class');

			$.get(imageUrl, function(data)
			{
				var $svg = $(data).find('svg');

				if (typeof imageID !== 'undefined')
				{
					$svg = $svg.attr('id', imageId);
				}

				if (typeof imageClass !== 'undefined')
				{
					$svg = $svg.attr('class', imageClass + ' replaced-svg');
				}

				$svg = $svg.removeAttr('xmlns:a');

				$image.replaceWith($svg);
			});
		});

		return this;
	};

	// Close Alerts
	Platform.App.closeAlerts = function(event)
	{
		$(event.delegateTarget).slideToggle(function()
		{
			$(this).remove();
		});
	};

	// Job done, lets run
	Platform.App.init();

})(window, document, jQuery);
