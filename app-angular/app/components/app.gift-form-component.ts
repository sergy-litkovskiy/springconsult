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
        'email': '',
        'isEmpty': true
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
        // const EMAIL_REGEXP = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i;
        const EMAIL_REGEXP = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i;

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

        for (let fieldName in data) {
            if (!data.hasOwnProperty(fieldName)) {
                continue;
            }
            // clear previous error message (if any)
            this.formErrors[fieldName] = '';
        }
    }

    validateForm () {
        if (!this.giftForm) {
            return false;
        }

        const form = this.giftForm;

        for (const field in this.formErrors) {
            if (field != 'isEmpty') {
                // clear previous error message (if any)
                this.formErrors[field] = '';
            }

            const control = form.get(field);

            if (control && !control.valid) {
                const messages = this.validationMessages[field];

                this.formErrors.isEmpty = false;

                for (const key in control.errors) {
                    this.formErrors[field] += messages[key] + ' ';
                }
            }
        }
    }

    renderFormError (message: string) : void {
        this.formErrors.isEmpty = false;

        if (message.match(/form/i)) {
            this.formErrors.email = 'Форма заполнена неверно';
            this.formErrors.userName = 'Форма заполнена неверно';
        } else if (message.match(/email\|required/i)) {
            this.formErrors.email = this.validationMessages.email.required;
        } else if (message.match(/email\|pattern/i)) {
            this.formErrors.email = this.validationMessages.email.pattern;
        } else if (message.match(/userName\|required/i)) {
            this.formErrors.userName = this.validationMessages.userName.required;
        }
    }

    onSubmit(): void {
        this.formErrors.isEmpty = true;

        this.validateForm();

        if (this.formErrors.isEmpty) {

            this.giftSubscribeModel.email = this.giftForm.get('email').value;
            this.giftSubscribeModel.userName = this.giftForm.get('userName').value;
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
                        this.renderFormError(errorMessage);
                    }
                );
        }
    }
}

