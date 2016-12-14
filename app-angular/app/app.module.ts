import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { GiftContainerComponent }  from './components/app.gift-component';

@NgModule({
  imports:      [ BrowserModule ],
  declarations: [ GiftContainerComponent ],
  bootstrap:    [ GiftContainerComponent ]
})

export class AppModule { }
