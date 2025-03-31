var skillsTicked = [];
var isOtherSkillsValid = false;


window.addEventListener('load',
    function () {
        this.onInitialLoad();
        this.registerEvents();
    }, false
);

function onInitialLoad() {
    let referenceNumber = localStorage.getItem('referenceNumber');
    if (referenceNumber) {
        document.querySelector('#reference').value = referenceNumber;
        document.querySelector('#reference').setAttribute('readonly', true);
    }
    this.prefillUserData();
    this.getTickedSkills();

}

function submitApplication() {
    let form = document.querySelector('#application-form');
    let isDateOfBirthValid = this.validateDateOfBirth();
    let isPostCodeValid = this.validatePostcode();
    isOtherSkillsValid = this.validateOtherSkills(true);
    this.getTickedSkills();

    let genderSelected = this.getSelectedGender();

    form.addEventListener('submit', function (e) {
        // prevent the form from submitting
        e.preventDefault();


        if (!isDateOfBirthValid || !isPostCodeValid || !isOtherSkillsValid) {
            return
        }
        let dataToSave = {};
        let name = document.querySelector('#name').value;
        let lastName = document.querySelector('#lastName').value;
        let dateOfBirth = document.querySelector('#dateOfBirth').value;
        let street = document.querySelector('#street').value;
        let town = document.querySelector('#town').value;
        let selectedState = document.querySelector('#state').value;
        let postalCode = document.querySelector('#postCode').value;
        let email = document.querySelector('#email').value;
        let phone = document.querySelector('#phone').value;

        let otherSkills = document.querySelector('#other-skills').value;

        dataToSave = {
            name: name,
            lastName: lastName,
            dateOfBirth: dateOfBirth,
        }

        if (genderSelected) {
            dataToSave = {
                ...dataToSave,
                gender: genderSelected,
            }
        }


        if (street) {
            dataToSave = {
                ...dataToSave,
                street: street,
            }
        }

        if (town) {
            dataToSave = {
                ...dataToSave,
                town: town,
            }
        }

        if (selectedState) {
            dataToSave = {
                ...dataToSave,
                state: selectedState,
            }
        }

        if (postalCode) {
            dataToSave = {
                ...dataToSave,
                postCode: postalCode,
            }
        }

        if (email) {
            dataToSave = {
                ...dataToSave,
                email: email,
            }
        }

        if (phone) {
            dataToSave = {
                ...dataToSave,
                phone: phone,
            }
        }

        if (skillsTicked.length !== 0) {
            dataToSave = {
                ...dataToSave,
                skills: skillsTicked,
            }
        }

        if (otherSkills) {
            dataToSave = {
                ...dataToSave,
                otherSkills: otherSkills,
            }
        }

        sessionStorage.setItem('user', JSON.stringify(dataToSave))

        //if everything is good we are good to submit
        console.log('congrats form submitted!', dataToSave)

    });
}

function validateDateOfBirth() {
    let dob = document.querySelector('#dateOfBirth').value;
    if (dob) {
        let selectedDateOfBirth = new Date(dob), startDate = new Date(), endDate = new Date();
        startDate.setFullYear(startDate.getFullYear() - 80);
        endDate.setFullYear(endDate.getFullYear() - 15);
        if (selectedDateOfBirth > endDate || selectedDateOfBirth < startDate) {
            document.querySelector('#dob-error').innerText = 'Applicants must be at between 15 and 80 years old at the time they fill in the form';
            return false;
        } else {
            document.querySelector('#dob-error').innerText = '';
        }
    }
    return true;
}

function validatePostcode() {
    let selectedState = document.querySelector('#state').value;
    let postalCode = document.querySelector('#postCode').value;
    let isMatching = true;
    if (postalCode) {
        const firstDigitStr = Number(String(postalCode)[0]);
        switch (selectedState) {
            case 'VIC':
                if (firstDigitStr !== 3 && firstDigitStr !== 8) isMatching = false;
                break;
            case 'NSW':
                if (firstDigitStr !== 1 && firstDigitStr !== 2) isMatching = false;
                break;
            case 'QLD':
                if (firstDigitStr !== 4 && firstDigitStr !== 9) isMatching = false;
                break;
            case 'NT':
                if (firstDigitStr !== 0) isMatching = false;
                break;
            case 'WA':
                if (firstDigitStr !== 6) isMatching = false;
                break;
            case 'SA':
                if (firstDigitStr !== 5) isMatching = false;
                break;
            case 'TAS':
                if (firstDigitStr !== 7) isMatching = false;
                break;
            case 'ACT':
                if (firstDigitStr !== 0) isMatching = false;
                break;
            default: ;
        }
        if (isMatching === false) {
            document.querySelector('#postCode-error').innerText = `the postcode ${postalCode} should match the state ${selectedState}`;
        } else {
            document.querySelector('#postCode-error').innerText = '';
        }
    }
    return isMatching;
}

function validateOtherSkills(callFromSubmit) {
    let isOtherSkillsChecked = document.querySelector('#check6').checked;
    let otherSkillsText = document.querySelector('#other-skills').value;
    if (isOtherSkillsChecked === true) {
        if (!otherSkillsText || otherSkillsText === '') {
            document.querySelector('#other-skills-error').innerText = 'Other Skills text area cannot be blank';
            return false;
        }
        if (callFromSubmit) {
            this.tickSkill('check6');
        }
        document.querySelector('#other-skills-error').innerText = '';

    } else {
        skillsTicked = skillsTicked.filter(s => s !== 'check6') ?? [];
        document.querySelector('#other-skills-error').innerText = '';
    }
    return true;
}

function tickSkill(id) {
    const isAlreadyTicked = skillsTicked?.find((item) => item === id);
    if (isAlreadyTicked) {
        const filteredSkills = skillsTicked.filter(s => s !== isAlreadyTicked) ?? [];
        skillsTicked = filteredSkills;
        return
    }
    skillsTicked.push(id);
}

function getTickedSkills() {
    let selected = document.querySelectorAll('input[name=skillCheckboxes]:checked');
    if (selected) {
        selected?.forEach((val) => {
            if (!skillsTicked.includes(val.id)) skillsTicked.push(val?.id)

        })
    }
}

function getSelectedGender() {
    let selected = document.querySelector('input[name=gender]:checked');
    return selected?.value ?? null
}

function prefillUserData() {
    let userData = sessionStorage.getItem('user');
    if (userData) {
        userData = JSON.parse(userData);
        document.querySelector('#name').value = userData?.name;
        document.querySelector('#lastName').value = userData?.lastName;
        document.querySelector('#dateOfBirth').value = userData?.dateOfBirth;
        document.querySelector('#street').value = userData?.street;
        document.querySelector('#town').value = userData?.town;
        document.querySelector('#state').value = userData?.state;
        document.querySelector('#postCode').value = userData?.postCode;
        document.querySelector('#email').value = userData?.email;
        document.querySelector('#phone').value = userData?.phone;
        document.querySelector('#other-skills').value = userData?.otherSkills;
        if (userData?.gender) {
            document.querySelector(`#${userData.gender}`).checked = true;
        }
        if (userData?.skills) {
            userData?.skills?.forEach((item) => {
                document.querySelector(`#${item}`).checked = true
            })
        }

    }
}


function registerEvents() {
    document.querySelector('#submit').addEventListener("click", () => {
        this.submitApplication();
    });
    document.querySelector('#dateOfBirth').addEventListener("change", () => {
        this.validateDateOfBirth();
    });
    document.querySelector('#state').addEventListener("change", () => {
        this.validatePostcode();
    });
    document.querySelector('#postCode').addEventListener("change", () => {
        this.validatePostcode();
    });
    document.querySelector('#check6').addEventListener("change", () => {
        this.validateOtherSkills(false);
    });
    document.querySelector('#other-skills').addEventListener("change", () => {
        this.validateOtherSkills(false);
    });
    document.querySelector('#check1').addEventListener("click", () => {
        this.tickSkill('check1');
    });
    document.querySelector('#check2').addEventListener("click", () => {
        this.tickSkill('check2');
    });
    document.querySelector('#check3').addEventListener("click", () => {
        this.tickSkill('check3');
    });
    document.querySelector('#check4').addEventListener("click", () => {
        this.tickSkill('check4');
    });
    document.querySelector('#check5').addEventListener("click", () => {
        this.tickSkill('check5');
    });

}
