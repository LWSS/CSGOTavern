<?php

/**
 * Part of the Platform Installer extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform Installer extension
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Bootstrap\Requirements;

/*
|--------------------------------------------------------------------------
| Platform requirement rules
|--------------------------------------------------------------------------
|
| Conducts checks for several requirements that must be met in order
| to run Platform.
|
| Note: Laravel hasn't been booted, you can't use Composer or any helper.
|
*/

interface RequirementInterface
{
    /**
     * Performs the requirement check.
     *
     * @param  array  $paths
     * @return bool
     */
    public function check($paths = []);

    /**
     * Returns the title translation key.
     *
     * @return string
     */
    public function title();

    /**
     * Returns the message translation key.
     *
     * @return string
     */
    public function message();
}

class DependenciesRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return file_exists(realpath(__DIR__.'/../vendor'));
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'Composer Dependencies';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'Composer dependencies missing.';
    }
}

class StoragePermissionsRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return is_writable(realpath($paths['storage']));
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'Storage Write Permissions';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'storage must be writable.';
    }
}

class PublicPermissionsRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return is_writable(realpath($paths['public'].'/cache'));
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'Cache Write Permissions';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'public/cache must be writable.';
    }
}

class McryptExtensionRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return extension_loaded('mcrypt');
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'Mcrypt PHP Extension';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'Mcrypt extension is required.';
    }
}

class GDExtensionRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return extension_loaded('gd');
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'GD PHP Extensions';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'GD extension is required.';
    }
}

class PDOExtensionRequirement implements RequirementInterface
{
    /**
     * {@inheritDoc}
     */
    public function check($paths = [])
    {
        return defined('PDO::ATTR_DRIVER_NAME');
    }

    /**
     * {@inheritDoc}
     */
    public function title()
    {
        return 'PDO PHP Extension';
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return 'PDO extension is required.';
    }
}

/*
|--------------------------------------------------------------------------
| Register the desired requirements
|--------------------------------------------------------------------------
|
| Once we have all our rules created, let's define which ones should
| run in order to boot our application.
|
*/

$requirements = [
    new DependenciesRequirement,
    new StoragePermissionsRequirement,
    new PublicPermissionsRequirement,
    new McryptExtensionRequirement,
    new GDExtensionRequirement,
    new PDOExtensionRequirement,
];

/*
|--------------------------------------------------------------------------
| BOOM! Check the requirements
|--------------------------------------------------------------------------
|
| Finally, let's run over all our requirement classes. If any of them
| fails, we will stop the execution and return some raw HTML.
|
*/

$paths = [
    'storage' => realpath(__DIR__.'/../storage'),
    'public'  => realpath(__DIR__.'/../public'),
];

$pass = true;

foreach ($requirements as $requirement) {
    if (! $requirement->check($paths)) {
        $pass = false;
        break;
    }
}

?>
<?php if (! $pass): ?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Installation Checks</title>
		<style>

			article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}
			audio,canvas,progress,video{display:inline-block;}
			html{font-size:100%;}
			body{font-family: ‘Lucida Console’, Monaco, monospace;line-height:1.5;margin:0; overflow-x:hidden;}
			address,blockquote,dd,dl,fieldset,form,hr,menu,ol,p,pre,q,table,ul{margin:0 0 1.25em;}
			h1,h2,h3,h4,h5,h6{line-height:1.25;}

			* { margin: 0; padding: 0; }

			hr {
				border:1px solid #eee;
				margin:32px 0;
			}

			h1, h2 {
				margin-top: 21px;
				margin-bottom: 10.5px;
				font-weight: 400;
				line-height: 1.1;
				color: inherit;
			}

			h1 {
				font-size: 2em;
				margin: 0.67em 0;
			}

			.install {
				text-align: center;
			}

			.install > header {
				position: absolute;
				top:40px;
				width:100%;
				z-index: 2;
			}

			.install > section {
				background:#fff;
				width: 100%;
				position:absolute;
				z-index: 3;
				top:200px;
				bottom:0;
			}

			.brand {
				position:relative;
				bottom: 0px;

				-webkit-animation: bot_float ease 3s 4;
				-moz-animation: bot_float ease 3s 4;
				-ms-animation: bot_float ease 3s 4;
				animation: bot_float ease 3s 4;
			}

			.brand__image img {
				max-width: 280px;
			}

			@-webkit-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@-moz-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@-ms-keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }
			@keyframes bot_float { 50% { bottom: -40px; } 100% { bottom: 0px; } }

			.page {
				padding:0 16px;
			}

			.page__wrapper {
				background: white;
				border-radius: 10px;
				padding: 2em;
				border:1px solid #ddd;
				max-width:800px;
				margin:0 auto 32px auto;
			}

			.errors {
				max-width:640px;
				margin:0 auto;
			}

			.alert {
				padding: 15px;
				margin-bottom: 21px;
				border: 1px solid transparent;
				border-radius: 4px;
			}

			.alert-danger {
				background-color: #e74c3c;
				border-color: #e74c3c;
				color: #ffffff;
			}

			.alert-success {
				background-color: #18bc9c;
				border-color: #18bc9c;
				color: #ffffff;
			}

			.btn {
				display: inline-block;
				margin-bottom: 0;
				font-weight: normal;
				text-align: center;
				vertical-align: middle;
				cursor: pointer;
				background-image: none;
				border: 1px solid transparent;
				white-space: nowrap;
				padding: 10px 15px;
				font-size: 15px;
				line-height: 1.42857143;
				border-radius: 4px;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				text-decoration: none;
			}

			.btn-lg {
				padding: 18px 27px;
				font-size: 19px;
				line-height: 1.33;
				border-radius: 6px;
			}

			.btn-primary {
				color: #ffffff;
				background-color: #2c3e50;
				border-color: #2c3e50;
			}

			.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
				color: #ffffff;
				background-color: #1a242f;
				border-color: #161f29;
			}

		</style>

	</head>
	<body>

		<section class="install">

			<header>
				<div class="brand">
					<div class="brand__image">
						<img src="brand.svg" alt="Ornery Octopus">
					</div>
				</div>
			</header>

			<section class="page">

				<div class="page__wrapper">

					<header>
						<h1>Installation Requirements</h1>
						<h3 class="text-danger">Woah there high speed. We found a few issues.</h3>
						<hr>
					</header>

					<section class="errors">

						<?php foreach ($requirements as $requirement): ?>

							<?php if (! $requirement->check($paths)): ?>
								<div class="alert alert-danger" role="alert"><?php echo $requirement->message(); ?></div>
							<?php else: ?>
								<div class="alert alert-success" role="alert"><?php echo $requirement->message(); ?></div>
							<?php endif; ?>

						<?php endforeach; ?>

						<a href="" class="btn btn-primary btn-lg">Refresh</a>

					</section>
				</div>
			</section>
		</section>

	</body>
	</html>

	<?php exit(1); ?>
<?php endif; ?>
