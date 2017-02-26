import {Component, OnInit, Input} from '@angular/core';
import {GiftService} from '../services/gift-service';
import {GiftSubscribeModel} from '../models/gift-subscribe-model';
import {GiftModel} from '../models/gift-model';
import {FormGroup, Validators, FormBuilder} from '@angular/forms';

@Component({
    selector: 'gift-form',
    templateUrl: '/app-angular/app/components/app.gift-form-view.html',
    providers: [GiftService]
})

export class GiftFormComponent implements OnInit {
    giftSubscribeModel: GiftSubscribeModel;
    giftForm: FormGroup;
    @Input() giftModel: GiftModel;

    constructor(private giftService: GiftService, private fb: FormBuilder) {
        this.giftSubscribeModel = new GiftSubscribeModel(null, null, null, null);
    }

    submitted = false;

    formErrors = {
        'userName': '',
        'email': ''
    };

    validationMessages = {
        'userName': {
            'required': 'Заполните поле Имя',
            'minlength': 'Введите не менее 2 символов'
        },
        'email': {
            'required': 'Заполните поле Email',
            'pattern': 'Неверный формат Email'
        }
    };

    ngOnInit() {
        this.buildForm();
    }

    buildForm(): void {
        const EMAIL_REGEXP = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i;
        this.giftForm = this.fb.group({
            'userName': [
                this.giftSubscribeModel.userName, [
                    Validators.required,
                    Validators.minLength(2)
                ]
            ],
            'email': [
                this.giftSubscribeModel.email, [
                    Validators.required,
                    Validators.pattern(EMAIL_REGEXP)
                ]
            ]
        });

        this.giftForm.valueChanges
            .subscribe(data => {
                this.onValueChanged(data)
            });

    }

    onValueChanged (data?: any) {
        if (!this.giftForm) {
            return false;
        }

        const form = this.giftForm;

        for (const field in this.formErrors) {
            // clear previous error message (if any)
            this.formErrors[field] = '';
            const control = form.get(field);

            if (control && control.dirty && !control.valid) {
                const messages = this.validationMessages[field];

                for (const key in control.errors) {
                    this.formErrors[field] += messages[key] + ' ';
                }
            }
        }
    }

    renderFormError (message: string) : void {
console.log('renderFormError', message);
        let patternForm = new RegExp("form");
        let patternEmailRequired = new RegExp("email|required");
        let patternEmailInvalid = new RegExp("email|pattern");
        let patternUsernameRequired = new RegExp("userName|pattern");

        if (patternForm.test(message)) {
            this.formErrors.email = 'Форма заполнена неверно';
            this.formErrors.userName = 'Форма заполнена неверно';
        } else if (patternEmailRequired.test(message)) {
            this.formErrors.email = this.validationMessages.email.required;
        } else if (patternEmailInvalid.test(message)) {
            this.formErrors.email = this.validationMessages.email.pattern;
        } else if (patternUsernameRequired.test(message)) {
            console.log('HERE');
            console.log(this.validationMessages.userName.required);
            this.formErrors.email = this.validationMessages.userName.required;
        }
    }

    onSubmit(): void {
        this.onValueChanged();
console.log('onSubmit - formErrors', this.formErrors);
        this.submitted = true;

        this.giftSubscribeModel.email = this.formErrors.email;
        this.giftSubscribeModel.userName = this.formErrors.userName;
        this.giftSubscribeModel.giftId = this.giftModel.giftId;
        this.giftSubscribeModel.giftName = this.giftModel.giftImage;

        this.giftService
            .sendGiftRequest(this.giftSubscribeModel)
            .subscribe(
                data => {
                    this.giftForm.get('email').setValue('');
                    this.giftForm.get('userName').setValue('');

                    window.location.href = data.data;
                },
                errorMessage => {
console.log('sendGift subscribe - errorMessage', errorMessage);
                    this.renderFormError(errorMessage);
                }
            );
    }
}

