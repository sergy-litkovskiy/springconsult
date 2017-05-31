import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppMainComponent } from './app.main.component';
import {AppRoutingModule} from "./app.routing.module";

@NgModule({
  declarations: [
    AppMainComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppMainComponent]
})
export class AppModule { }
