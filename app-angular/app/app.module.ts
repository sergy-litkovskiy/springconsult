import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { GiftFormComponent }  from './components/app.gift-component';

@NgModule({
  imports:      [ BrowserModule ],
  declarations: [ GiftFormComponent ],
  bootstrap:    [ GiftFormComponent ]
})

export class AppModule { }
