<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

// Paths to your views directory and compiled views directory
$viewPaths = [__DIR__ . '/app/Views'];
$cachePath = __DIR__ . '/cache';

// Create a new Blade compiler instance
$bladeCompiler = new BladeCompiler(new Filesystem(), $cachePath);

// Create a new file view finder instance
$fileViewFinder = new FileViewFinder(new Filesystem(), $viewPaths);

// Create a new Factory instance and register the Blade engine
$viewFactory = new Factory($bladeCompiler, $fileViewFinder);
$viewFactory->addExtension('blade.php', 'blade', function () use ($bladeCompiler) {
    return new CompilerEngine($bladeCompiler);
});

return $viewFactory;
