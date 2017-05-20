import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AppMainComponent }   from '../main/app.main.component';

const routes: Routes = [
    { path: '', redirectTo: '/main', pathMatch: 'full' },
    { path: 'main',  component: AppMainComponent },
];

@NgModule({
    imports: [ RouterModule.forRoot(routes) ],
    exports: [ RouterModule ]
})
export class AppRoutingModule {}