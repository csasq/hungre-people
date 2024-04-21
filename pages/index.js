const firstBurgerLine = document.getElementById('first-line');
const secondBurgerLine = document.getElementById('second-line');
const thirdBurgerLine = document.getElementById('third-line');

const signInLink = document.querySelector('a[href="#sign-in"]');
const signUpLink = document.querySelector('a[href="#sign-up"]');
const accountLink = document.querySelector('a[href="#account"]');
const signInMobileLink = document.querySelector('a[href="#sign-in-mobile"]');
const accountMobileLink = document.querySelector('a[href="#account-mobile"]');
const emailAddressElements = document.querySelectorAll('input[type="email"]');
const emailAddressElement = document.querySelector('#email-address');
const signInExceptionElement = document.querySelector('#sign_in__exception');
const signUpExceptionElement = document.querySelector('#sign_up__exception');
const accountExceptionElement = document.querySelector('#account__exception');
const bookingDateElement = document.querySelector('#booking__date');
const menuListsElement = document.querySelector('#menu__lists');
const menuButtonElements = document.querySelectorAll('.menu__button');

const burgerIcon = document.querySelector('.burger-icon');
const burgerMenu = document.querySelector('.burger__list');

const signInForm = document.querySelector('.sign_in__form');
const signUpForm = document.querySelector('.sign_up__form');
const accountForm = document.querySelector('.account__form');
const bookingForm = document.querySelector('.booking__form');
const contactForm = document.querySelector('.contact__form');

function switchBurgerIcon() {
    firstBurgerLine.classList.toggle('burger-icon__line_animation_first-line');
    secondBurgerLine.classList.toggle('burger-icon__line_animation_second-line');
    thirdBurgerLine.classList.toggle('burger-icon__line_animation_third-line');

    burgerMenu.classList.toggle('burger__list_active');
}

burgerIcon.addEventListener('click', switchBurgerIcon);

class Popup {
    constructor(popupSelector) {
        this._popup = document.querySelector(popupSelector);
        this._closeButton = this._popup.querySelector('.popup__close-button');
    }

    openPopup() {
        this._popup.classList.add('popup_opened');
    }

    closePopup() {
        this._popup.classList.remove('popup_opened');
        this._removeEventListeners();
    }

    _closePopupByPressEsc(evt) {
        if (evt.key === 'Escape') {
            this.closePopup();
        }
    }

    _closePopupByClickOnOverlay(evt) {
        if (evt.target === this._popup) {
            this.closePopup();
        }
    }

    setEventListeners() {
        this._closeButton.addEventListener('click', () => {
            this.closePopup();
        });

        document.addEventListener('keydown', (evt) => {
            this._closePopupByPressEsc(evt);
        });

        this._popup.addEventListener('mousedown', (evt) => {
            this._closePopupByClickOnOverlay(evt);
        });
    }

    _removeEventListeners() {
        this._closeButton.removeEventListener('click', () => {
            this.closePopup();
        });

        document.removeEventListener('keydown', (evt) => {
            this._closePopupByPressEsc(evt);
        });

        this._popup.removeEventListener('mousedown', (evt) => {
            this._closePopupByClickOnOverlay(evt);
        });
    }
}

const bookingDateFrom = new Date();
bookingDateFrom.setDate(bookingDateFrom.getDate() + 1);
bookingDateElement.min = bookingDateFrom.toISOString().split('T')[0];

const popupSignIn = new Popup('.popup_type_sign_in');
popupSignIn.setEventListeners();

const popupSignUp = new Popup('.popup_type_sign_up');
popupSignUp.setEventListeners();

const popupAccount = new Popup('.popup_type_account');
popupAccount.setEventListeners();

const popupConfirmation = new Popup('.popup_type_booking');
popupConfirmation.setEventListeners();

const popupContact = new Popup('.popup_type_contact');
popupContact.setEventListeners();

signInLink.addEventListener('click', (e) => {
    e.preventDefault();
    popupSignIn.openPopup();
});

signInMobileLink.addEventListener('click', (e) => {
    e.preventDefault();
    popupSignIn.openPopup();
});

const signIn = async (emailAddress, body) => {
    const response = await fetch('/api/sessions/', {
        method: 'post',
        body: body,
    });
    if (response.ok) {
        popupSignIn.closePopup();
        signInLink.parentElement.style.display = 'none';
        signInMobileLink.parentElement.style.display = 'none';
        accountLink.parentElement.style.display = null;
        accountMobileLink.parentElement.style.display = null;
        emailAddressElement.textContent = emailAddress;
        emailAddressElements.forEach(element => {
            element.value = emailAddress;
            element.disabled = true;
        });
        popupAccount.openPopup();
        signInForm.reset();
        signInExceptionElement.style.display = 'none';
    } else {
        signInExceptionElement.style.display = null;
    }
};

signInForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailAddress = signInForm.querySelector('input[type="email"]').value.toLowerCase().trim();
    const body = new URLSearchParams();
    body.set('method', 'POST');
    body.set('email_address', emailAddress);
    body.set('password', signInForm.querySelector('input[type="password"]').value);
    await signIn(emailAddress, body);
});

signUpLink.addEventListener('click', (e) => {
    e.preventDefault();
    popupSignIn.closePopup();
    popupSignUp.openPopup();
});

signUpForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailAddress = signUpForm.querySelector('input[type="email"]').value.toLowerCase().trim();
    const body = new URLSearchParams();
    body.set('method', 'POST');
    body.set('email_address', emailAddress);
    body.set('password', signUpForm.querySelector('input[type="password"]').value);
    const response = await fetch('/api/users/', {
        method: 'post',
        body: body,
    });
    if (response.ok) {
        popupSignUp.closePopup();
        signUpLink.parentElement.style.display = 'none';
        accountLink.parentElement.style.display = null;
        accountMobileLink.parentElement.style.display = null;
        await signIn(emailAddress, body);
        emailAddressElement.textContent = emailAddress;
        popupAccount.openPopup();
        signUpForm.reset();
        signUpExceptionElement.style.display = 'none';
    } else {
        signUpExceptionElement.style.display = null;
    }
});

accountLink.addEventListener('click', (e) => {
    e.preventDefault();
    popupAccount.openPopup();
});

accountMobileLink.addEventListener('click', (e) => {
    e.preventDefault();
    popupAccount.openPopup();
});

accountForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const body = new URLSearchParams();
    body.set('method', 'DELETE');
    const response = await fetch('/api/sessions/', {
        method: 'post',
        body: body,
    });
    if (response.ok) {
        popupAccount.closePopup();
        accountLink.parentElement.style.display = 'none';
        accountMobileLink.parentElement.style.display = 'none';
        signInLink.parentElement.style.display = null;
        signInMobileLink.parentElement.style.display = null;
        emailAddressElement.textContent = '';
        emailAddressElements.forEach(element => {
            element.value = '';
            element.disabled = false;
        });
        accountForm.reset();
        accountExceptionElement.style.display = 'none';
    } else {
        accountExceptionElement.style.display = null;
    }
});

bookingForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitButton = bookingForm.querySelector('#booking__submit');
    submitButton.disabled = true;
    const emailAddressElement = bookingForm.querySelector('#booking__email_address');
    const name = bookingForm.querySelector('#booking__name').value.toLowerCase().trim();
    const emailAddress = emailAddressElement.value.toLowerCase().trim();
    const phoneNumber = bookingForm.querySelector('#booking__phone_number').value.toLowerCase().trim();
    const peopleNumber = bookingForm.querySelector('#booking__people_number').value.toLowerCase().trim();
    const date = bookingForm.querySelector('#booking__date').value.toLowerCase().trim();
    const time = bookingForm.querySelector('#booking__time').value.toLowerCase().trim();
    const body = new URLSearchParams();
    body.set('method', 'POST');
    body.set('name', name);
    body.set('email_address', emailAddress);
    body.set('phone_number', phoneNumber);
    body.set('people_number', peopleNumber);
    body.set('datetime', `${date}T${time}`);
    const response = await fetch('/api/bookings/', {
        method: 'post',
        body: body,
    });
    if (response.ok) {
        popupConfirmation.openPopup();
        bookingForm.reset();
        if (emailAddressElement.disabled)
            emailAddressElement.value = emailAddress;
    }
    submitButton.disabled = false;
});

contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitButton = contactForm.querySelector('#contact__submit');
    submitButton.disabled = true;
    const emailAddressElement = contactForm.querySelector('#contact__email_address');
    const name = contactForm.querySelector('#contact__name').value.toLowerCase().trim();
    const emailAddress = emailAddressElement.value.toLowerCase().trim();
    const phoneNumber = contactForm.querySelector('#contact__phone_number').value.toLowerCase().trim();
    const message = contactForm.querySelector('#contact__message').value.toLowerCase().trim();
    const body = new URLSearchParams();
    body.set('method', 'POST');
    body.set('name', name);
    body.set('email_address', emailAddress);
    body.set('phone_number', phoneNumber);
    body.set('message', message);
    const response = await fetch('/api/feedback/', {
        method: 'post',
        body: body,
    });
    if (response.ok) {
        popupConfirmation.openPopup();
        contactForm.reset();
        if (emailAddressElement.disabled)
            emailAddressElement.value = emailAddress;
    }
    submitButton.disabled = false;
});

const templateMenu = (target) => {
    menuListsElement.replaceChildren();
    for (let i = 0; i < 3; i++) {
        const list = document.createElement('ul');
        list.classList.add('menu__list');
        list.classList.add('list');
        for (let j = 0; j < 7; j++) {
            const item = document.createElement('li');
            item.classList.add('menu__item');
            const text = document.createElement('div');
            text.classList.add('menu__text');
            const name = document.createElement('h3');
            name.classList.add('menu__name');
            name.textContent = `${target.toUpperCase()} QUATRO STAGIONI . . .`;
            const description = document.createElement('p');
            description.classList.add('menu__description');
            description.textContent = 'Integer ullamcorper neque eu purus euismod';
            const price = document.createElement('p');
            price.classList.add('menu__price');
            price.textContent = '55,68 USD';
            text.append(name);
            text.append(description);
            item.append(text);
            item.append(price);
            list.append(item);
        }
        menuListsElement.append(list);
    }
};

templateMenu('pizza');

menuButtonElements.forEach(element => element.addEventListener('click', () => templateMenu(element.textContent)));

ymaps3.ready.then(() => {
    const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker} = ymaps3;
    const map = new YMap(
        document.querySelector('#map'),
        {
            location: {
                center: [37.611311, 54.183523],
                zoom: 18,
            },
        },
    );
    map.addChild(new YMapDefaultSchemeLayer());
    map.addChild(new YMapDefaultFeaturesLayer());
    const content = document.createElement('section');
    content.style.marginTop = '-.5rem';
    content.style.marginLeft = '-.5rem';
    content.style.width = '1rem';
    content.style.height = '1rem';
    content.style.backgroundColor = 'red';
    content.style.border = 'solid 2px white';
    content.style.outline = 'solid 2px red';
    content.style.borderRadius = '1rem';
    // content.style.overflow = 'hidden';
    const marker = new YMapMarker({
        coordinates: [37.611311, 54.183523],
        draggable: false,
    }, content);
    map.addChild(marker);
});
