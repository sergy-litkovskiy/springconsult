import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { GiftContainerComponent }  from './components/app.gift-component';
import { HttpModule } from '@angular/http';
import { FormsModule } from '@angular/forms';

// import { GiftService }  from './services/gift-service';

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpModule ],
  declarations: [ GiftContainerComponent ],
  bootstrap:    [ GiftContainerComponent ]
})

export class AppModule { }
