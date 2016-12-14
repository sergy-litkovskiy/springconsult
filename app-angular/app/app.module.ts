import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { GiftContainerComponent }  from './components/app.gift-component';
import { GiftFormListComponent }  from './components/app.gift-form-list.component';

@NgModule({
  imports:      [ BrowserModule ],
  declarations: [ GiftContainerComponent, GiftFormListComponent ],
  bootstrap:    [ GiftContainerComponent ]
})

export class AppModule { }
