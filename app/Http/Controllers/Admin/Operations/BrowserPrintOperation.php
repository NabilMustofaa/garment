<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait BrowserPrintOperation
{
   /**
    * Define which routes are needed for this operation.
    *
    * @param string $segment    Name of the current entity (singular). Used as first URL segment.
    * @param string $routeName  Prefix of the route name.
    * @param string $controller Name of the current CrudController.
    */
   protected function setupBrowserPrintRoutes($segment, $routeName, $controller)
   {
       Route::get($segment . '/{id}/browserprint', [
           'as'        => $routeName . '.BrowserPrint',
           'uses'      => $controller . '@BrowserPrint',
           'operation' => 'BrowserPrint',
       ]);
   }

   /**
    * Add the default settings, buttons, etc that this operation needs.
    */
   protected function setupBrowserPrintDefaults()
   {
       $this->crud->allowAccess('browserprint');

       $this->crud->operation('browserprint', function () {
           $this->crud->loadDefaultOperationSettingsFromConfig();
       });

       $this->crud->operation(['list', 'show'], function () {
           $this->crud->addButton('line', 'browserprint', 'view', 'crud::buttons.print');
       });
   }

   /**
    * Show the view for performing the operation.
    *
    * @return Response
    */
   public function browserprint()
   {
       $this->crud->hasAccessOrFail('browserprint');

       $this->data['crud'] = $this->crud;
       $this->data['title'] = $this->crud->getTitle() ?? 'print ' . $this->crud->entity_name;
       $this->data['entry'] = $this->crud->getCurrentEntry();

       // load the view
       return view($this->crud->getCurrentEntry()->print_view, $this->data);
   }
}