import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { GiftContainerComponent }  from './components/app.gift-component';
import { HttpModule } from '@angular/http';
import { FormsModule } from '@angular/forms';
import { GiftFormComponent } from "./components/app.gift-form-component";
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpModule, ReactiveFormsModule ],
  declarations: [ GiftContainerComponent, GiftFormComponent ],
  bootstrap:    [ GiftContainerComponent ]
})

export class AppModule { }
