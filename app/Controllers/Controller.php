<?php

namespace App\Controllers;

use App\Models\KPI;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;

class Controller
{
    protected $view;

    public function __construct()
    {
        // Add the correct view paths to the view finder
        $viewPaths = [__DIR__ . '/../Views'];
        $cachePath = __DIR__ . '/../../cache'; // Use the appropriate cache path based on your project structure

        // Create a new Filesystem instance
        $filesystem = new Filesystem();

        // Create a new Blade compiler instance
        $bladeCompiler = new BladeCompiler($filesystem, $cachePath);

        // Create a new EngineResolver instance
        $engineResolver = new EngineResolver();

        // Register the Blade engine with the resolver
        $engineResolver->register('blade', function () use ($bladeCompiler) {
            return new CompilerEngine($bladeCompiler);
        });

        // Create a new FileViewFinder instance
        $fileViewFinder = new FileViewFinder($filesystem, $viewPaths);

        // Create a new Dispatcher instance
        $dispatcher = new Dispatcher();

        // Create a new Factory instance and pass the EngineResolver, FileViewFinder, and Dispatcher
        $this->view = new Factory($engineResolver, $fileViewFinder, $dispatcher);
    }
}
