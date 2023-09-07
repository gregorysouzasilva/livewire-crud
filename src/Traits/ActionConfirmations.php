<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ActionConfirmations {
    public function actionConfirm($method, $id, $confirmation = null) {
        // if no confirmation is needed, just run the method
          if (empty($confirmation)) {
               $this->actionRunModel($method, $id);
               return;
          }
             $this->confirmModel(
                 type: 'warning',
                 title: 'Are you sure?',
                 message: $confirmation,
                 id: $id,
                 method: $method,
                 modelClass: $this->modelClass ?? ''
             );
     }
 
     // Run model actions
     public function actionRunModel($method, $id, $modelClass = null) {
         if (!empty($modelClass) && $modelClass != $this->modelClass) {
             return;
         }
 
         $model = $this->modelClass::findOrFail($id);
         if (method_exists($model, $method)) {
             $model->{$method}($id);
             if (empty($model->errorMessage)) {
                 $this->toastr(
                     type: 'success',  
                     message: substr($method, 2) . ' done!',   
                 );
             } else {
                 $this->toastr(
                     type: 'error',  
                     title: 'Error',
                     message: $model->errorMessage ?? 'Action not executed.',);
             }
         } else {
             throw new \Exception('Method not found.');
         }
     }
 
     public function actionRun($method, $id, $modelClass = null) {
         if (!empty($modelClass) && $modelClass != $this->modelClass) {
             return;
         }
         if (method_exists($this, $method)) {
             $response = $this->{$method}(['id' => $id]);
             if (empty($response->errorMessage)) {
                 $this->toastr(
                     type: 'success',  
                     message: substr($method, 2) . ' done!',   
                 );
             } else {
                 $this->toastr(
                     type: 'error',  
                     title: 'Error',
                     message: $response->errorMessage ?? 'Action not executed.',);
             }
         } else {
             throw new \Exception('Method not found.');
         }
     }
}