'use strict';

var theme = {

    // THEME FUNTIONS
    init: function () {

        // Background image
        theme.bgImage();

        // Background image (mobile)
        theme.bgImageMobile();

        // Scroll to top
        theme.scrollTop();

        // header stiked
        theme.headerSticked();

        // Background image
        theme.navbarNav();

        // Change Language
        theme.changeLanguege();

        // Change Currency
        theme.changeCurrency();

        // Switch theme mode
        theme.switchMode();

        // Change Theme Color
        theme.changeThemeColor();

        // Change Avatar
        theme.changeAvatar();

        // Range price
        theme.rangePrice();

        // Countdown
        theme.countdown();

        // Animation
        theme.scrollCue();

        // Bootstrap dSelect
        theme.dSelect();

        // Select number of guests
        theme.selectGuest();

        // Open Check Availability Modal
        theme.openCheckAvailabilityModal();

        // Drodown checkboxes
        theme.dropdownCheckbox();

        // Hotel datepicker
        theme.datePicker();

        // Tiny Slider
        theme.swiperSlider();

        // Plyr Player
        theme.plyrPlayer();

        // Glightbox
        theme.gLightbox();

        // Bootstrap validation
        theme.bsValidation();

        // Highlight validation
        theme.highlight();

        // Code Snippet
        theme.codeSnippet();

        // preloader
        theme.preloader();

    },

    // BACKGROUND IMAGE
    bgImage: () => {
        // Select all elements with class 'bg-image'
        let bg = document.querySelectorAll(".bg-image");
        // Loop through each element
        for (let i = 0; i < bg.length; i++) {
            // Get value of 'data-image-src' attribute
            let url = bg[i].getAttribute('data-image-src');
            // Set 'backgroundImage' style property to URL of image
            bg[i].style.backgroundImage = "url('" + url + "')";
        }
    },

    // BACKGROUND IMAGE (MOBILE)
    bgImageMobile: () => {
        // Check if user agent matches any known mobile devices
        let isMobile = (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i)) ? true : false;
        // If device is mobile
        if (isMobile) {
            // Select all elements with class 'image-wrapper'
            document.querySelectorAll(".image-wrapper").forEach(e => {
                // Add class 'mobile' to each element
                e.classList.add("mobile")
            })
        }
    },

    // SCROLL TO TOP
    scrollTop: () => {
        // Select the scroll-top element
        const scrollTop = document.querySelector('.scroll-top');
        // If the scroll-top element exists
        if (scrollTop) {
            // Define a function to toggle the visibility of the scroll-top button
            const togglescrollTop = function () {
                // If the user has scrolled down more than 150 pixels from the top of the page
                window.scrollY > 150 ?
                    // Add the 'active' class to the scroll-top element to make it visible
                    scrollTop.classList.add('active') :
                    // Otherwise, remove the 'active' class to hide it
                    scrollTop.classList.remove('active');
            }
            // Run the togglescrollTop function when the page loads
            window.addEventListener('load', togglescrollTop);
            // Run the togglescrollTop function when the user scrolls the page
            document.addEventListener('scroll', togglescrollTop);

            // Define a function to smoothly scroll back to the top of the page when the scroll-top button is clicked
            const scrollToTop = function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
            // Add a click event listener to the scroll-top element to run the scrollToTop function when clicked
            scrollTop.addEventListener('click', scrollToTop);
        }
    },

    // HEADER STICKED
    headerSticked: () => {
        // Select the header element with id 'header'
        const header = document.querySelector('#header');
        if (header) {
            document.addEventListener('scroll', () => {
                if (window.scrollY > 200) {
                    header.classList.add('sticked');
                    window.scrollY >= 300 ? header.classList.add('showed') : header.classList.remove('showed');
                } else {
                    header.classList.remove('sticked')
                }
            });
        }
    },

    // NAVBAR NAV
    // 1. Add interactivity to Bootstrap Dropdown:
    // - Show the Dropdown-menu when the mouse enters a Dropdown or Dropdown-item.
    // - Hide the Dropdown-menu after a delay when the mouse leaves.
    // 2. Adds interactivity to an navbar in Off-canvas:
    // - Toggle the icons in Dropdown when Off-canvas is shown or hidden. 
    // - Show the Dropdown-menu when clicking on the toggle icon.
    // - Apply the ‘slideIn’ effect for the Dropdown-menu when showing.
    navbarNav: () => {

        // Select the offcanvas navbar element
        const offcanvasNavbars = document.querySelectorAll('.offcanvas.offcanvas-navbar');

        // If offcanvasNavbar elements exist
        offcanvasNavbars.forEach(offcanvasNavbar => {

            // Declare a variable named timeout
            let timeout;
            // Select all dropdown elements within the offcanvas navbar
            const dropdowns = offcanvasNavbar.querySelectorAll('.nav-item.dropdown');
            // Select all toggle icons within the offcanvas navbar
            const toggleIcons = offcanvasNavbar.querySelectorAll('.dropdown-toggle-icon');

            // Iterate over each dropdown element
            dropdowns.forEach(dropdown => {
                // Select the toggle and menu elements within the dropdown
                const toggle = dropdown.querySelector('.dropdown-toggle-hover');
                const menu = dropdown.querySelector('.dropdown-menu');

                // Check if both the toggle and menu elements exist
                if (toggle && menu) {
                    // Add an event listener for when the mouse enters either the toggle or menu element
                    [toggle, menu].forEach(el => el.addEventListener('mouseenter', () => {
                        // Check if the offcanvas navbar is not shown
                        if (!offcanvasNavbar.classList.contains('show')) {
                            // Clear any existing timeout
                            clearTimeout(timeout);

                            // Remove the show class from all shown menus within the offcanvas navbar
                            offcanvasNavbar.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));

                            // Add classes to the menu element
                            menu.classList.add('show');
                            menu.classList.add('animate', 'slideIn');
                        }
                    }));

                    // Add an event listener for when the mouse leaves either the toggle or menu element
                    [toggle, menu].forEach(el => el.addEventListener('mouseleave', () => {
                        // Check if the offcanvas navbar is not shown
                        if (!offcanvasNavbar.classList.contains('show')) {
                            // Set a timeout to remove classes from the menu element after a delay
                            timeout = setTimeout(() => {
                                menu.classList.remove('show');
                                menu.classList.remove('animate', 'slideIn');
                            }, 500);
                        }
                    }));
                }
            });

            // Add an event listener for when the offcanvas navbar is shown
            offcanvasNavbar.addEventListener('show.bs.offcanvas', () => {
                // Replace the class for each toggle icon
                toggleIcons.forEach(toggleIcon => {
                    toggleIcon.classList.replace("ti-chevron-down", "ti-plus");
                });
            });

            // Add an event listener for when the offcanvas navbar is hidden
            offcanvasNavbar.addEventListener('hide.bs.offcanvas', () => {
                // Replace the class for each toggle icon
                toggleIcons.forEach(toggleIcon => {
                    toggleIcon.classList.replace("ti-plus", "ti-chevron-down");
                    toggleIcon.classList.replace("ti-minus", "ti-chevron-down");
                });
            });

            // Add an event listener for when a toggle icon is clicked
            toggleIcons.forEach(toggleIcon => {
                toggleIcon.addEventListener('click', function (event) {
                    // Check if the offcanvas navbar is shown
                    if (offcanvasNavbar.classList.contains('show')) {
                        // Prevent default behavior of the event
                        event.preventDefault();

                        // Get the parent node of the clicked toggle icon
                        const parentNode = this.parentNode;

                        // Toggle the active class on the parent node
                        parentNode.classList.toggle('active');

                        // Get the next sibling of the parent node
                        const nextSibling = parentNode.nextElementSibling;

                        // Toggle the show class on the next sibling
                        nextSibling.classList.toggle('show');

                        // Toggle classes on the clicked toggle icon
                        toggleIcon.classList.toggle('ti-plus');
                        toggleIcon.classList.toggle('ti-minus');
                    }
                })
            });
        });

    },

    // CHANGE LANGUAGE
    changeLanguege: () => {
        // Select the element with the attribute 'data-lang-list'
        const langList = document.querySelector('[data-lang-list]');

        // Check if the element exists
        if (langList) {
            // Add an event listener for a 'click' event on the 'langList' element
            langList.addEventListener('click', function (event) {
                // Find the closest ancestor element with the attribute 'data-lang-toggle'
                const langToggle = event.target.closest('[data-lang-toggle]');
                // Check if the element exists
                if (langToggle) {
                    // Get the value of the 'data-lang-toggle' attribute
                    const lang = langToggle.getAttribute('data-lang-toggle');
                    // Set the 'src' attribute of the element with id 'imgFlag' to the path of the flag image for the selected language
                    document.querySelector('#imgFlag').src = '/assets/img/flags/' + lang + '.svg';
                    // Set the text content of the element with id 'spnLang' to the selected language
                    document.querySelector('#spnLang').textContent = lang;
                }
            });
        }
    },

    // CHANGE CURRENCY
    changeCurrency: () => {
        // Select the element with the attribute 'data-currency-list'
        const currencyList = document.querySelector('[data-currency-list]');

        // Check if the element exists
        if (currencyList) {
            // Add an event listener for a 'click' event on the 'currencyList' element
            currencyList.addEventListener('click', function (event) {
                // Find the closest ancestor element with the attribute 'data-currency-toggle'
                const currencyToggle = event.target.closest('[data-currency-toggle]');
                // Check if the element exists
                if (currencyToggle) {
                    // Get the value of the 'data-currency-toggle' attribute
                    const currency = currencyToggle.getAttribute('data-currency-toggle');
                    // Set the text content of the element with id 'spnCurrency' to the selected currency
                    document.querySelector('#spnCurrency').textContent = currency;
                }
            });
        }
    },

    // SELECT NUMBER OF GUESTS
    selectGuest: () => {
        {
            // Loop each element total number of guests
            document.querySelectorAll('[data-total-guest]').forEach(function (totalGuest) {
                // Select the input elements for adults and children, and elements to display the total number of adults and children
                const adultsInput = totalGuest.querySelector('input[data-input-adults=""]');
                const childrenInput = totalGuest.querySelector('input[data-input-children=""]');
                const totalAdultsSpan = totalGuest.querySelector('span[data-total-adults=""]');
                const totalChildrenSpan = totalGuest.querySelector('span[data-total-children=""]');

                // Select the button elements for incrementing or decrementing the number of adults and children
                const minusAdultsBtn = totalGuest.querySelector('button[data-minus-adults=""]');
                const plusAdultsBtn = totalGuest.querySelector('button[data-plus-adults=""]');
                const minusChildrenBtn = totalGuest.querySelector('button[data-minus-children=""]');
                const plusChildrenBtn = totalGuest.querySelector('button[data-plus-children=""]');

                //If there exist adult and child input elements
                if (adultsInput && childrenInput) {

                    // If the input elements for adults and children are empty, assign default values to them
                    if (adultsInput.value.trim() === '') {
                        adultsInput.value = 1;
                    }
                    if (childrenInput.value.trim() === '') {
                        childrenInput.value = 0;
                    }

                    // Display the total number of adults and children
                    totalAdultsSpan.innerText = `${adultsInput.value} ${(adultsInput.value > 1) ? 'Adults' : 'Adult'}`;
                    totalChildrenSpan.innerText = `${childrenInput.value} ${(childrenInput.value > 1) ? 'Children' : 'Child'}`;

                    // This is an adult number input event
                    adultsInput.addEventListener('input', () => {
                        const maxAdults = parseInt(adultsInput.dataset.adultsMax);
                        if (adultsInput.value > maxAdults) {
                            adultsInput.value = maxAdults;
                        }
                        if (adultsInput.value < 1) {
                            adultsInput.value = 1;
                        }
                        // Update the total number of adults
                        totalAdultsSpan.innerText = `${adultsInput.value} ${(adultsInput.value > 1) ? 'Adults' : 'Adult'}`;
                    });

                    // This is an children number input event
                    childrenInput.addEventListener('input', () => {
                        const maxChildren = parseInt(childrenInput.dataset.childrenMax);
                        if (childrenInput.value > maxChildren) {
                            childrenInput.value = maxChildren;
                        }
                        // Update the total number of children
                        totalChildrenSpan.innerText = `${childrenInput.value} ${(childrenInput.value > 1) ? 'Children' : 'Child'}`;
                    });

                    // This is a click event that reduces the number of adults
                    minusAdultsBtn.addEventListener('click', () => {
                        const currentValue = parseInt(adultsInput.value);
                        if (currentValue > 1) {
                            adultsInput.value = currentValue - 1;
                            // Update the total number of adults
                            totalAdultsSpan.innerText = `${adultsInput.value} ${(adultsInput.value > 1) ? 'Adults' : 'Adult'}`;
                        }
                    });

                    // This is a click event that increases the number of adults
                    plusAdultsBtn.addEventListener('click', () => {
                        const currentValue = parseInt(adultsInput.value);
                        const maxAdults = parseInt(adultsInput.dataset.adultsMax);
                        if (currentValue < maxAdults) {
                            adultsInput.value = currentValue + 1;
                            // Update the total number of adults
                            totalAdultsSpan.innerText = `${adultsInput.value} ${(adultsInput.value > 1) ? 'Adults' : 'Adult'}`;
                        }
                    });

                    // This is a click event that reduces the number of children
                    minusChildrenBtn.addEventListener('click', () => {
                        const currentValue = parseInt(childrenInput.value);
                        if (currentValue > 0) {
                            childrenInput.value = currentValue - 1;
                            // Update the total number of children
                            totalChildrenSpan.innerText = `${childrenInput.value} ${(childrenInput.value > 1) ? 'Children' : 'Child'}`;
                        }
                    });

                    // This is a click event that increases the number of children
                    plusChildrenBtn.addEventListener('click', () => {
                        const currentValue = parseInt(childrenInput.value);
                        const maxChildren = parseInt(childrenInput.dataset.childrenMax);
                        if (currentValue < maxChildren) {
                            childrenInput.value = currentValue + 1;
                            // Update the total number of children
                            totalChildrenSpan.innerText = `${childrenInput.value} ${(childrenInput.value > 1) ? 'Children' : 'Child'}`;
                        }
                    });

                    // The number of adults and children must be digits from 0-9
                    function validateNumberInput(input) {
                        input.addEventListener('keypress', function (e) {
                            const keyCode = e.keyCode || e.which;
                            const keyValue = String.fromCharCode(keyCode);

                            if (!/^\d*$/.test(keyValue)) {
                                e.preventDefault();
                            }
                        });
                    }
                    validateNumberInput(adultsInput);
                    validateNumberInput(childrenInput);

                }
            });

        }
    },

    // Open Check tour Modal
    openCheckAvailabilityModal: () => {
        const form = document.querySelector('#frmCheckAvailability');
        const modal = document.getElementById('mdlCheckAvailability');

        if (form && modal) {
            form.addEventListener('submit', function (e) {
                if (this.checkValidity()) {
                    e.preventDefault();
                    let myModal = new bootstrap.Modal(modal, {
                        keyboard: false
                    });
                    myModal.show();
                }
            });
        }
    },

    /* DROPDOWN CHECKBOXES */
    dropdownCheckbox: () => {
        {
            // Select all dropdown checkboxes
            document.querySelectorAll('[data-dropdown-checkbox]').forEach(function (element) {

                // Select the dropdown checkboxes and toggle button
                const checkboxAll = element.querySelector('input[data-checkbox-type="all"]');
                const checkboxOne = element.querySelectorAll('input[data-checkbox-type="one"]');
                const spanSelected = element.querySelector('span[data-selected]');

                // If checkbox (all) is checked, uncheck checkbox (one) and set toggle button text
                if (checkboxAll.checked) {
                    spanSelected.textContent = checkboxAll.value;
                    checkboxOne.forEach((cb) => { cb.checked = false; });
                } else {
                    // Check the status of dropdown checkboxes
                    CheckCheckbox();
                }

                // Event listener for changes to checkbox (all)
                checkboxAll.addEventListener('change', function () {
                    if (this.checked) {
                        // If checkbox (all) is checked, uncheck checkbox (one) and set toggle button text
                        checkboxOne.forEach(function (checkbox) {
                            checkbox.checked = false;
                        });
                        spanSelected.textContent = checkboxAll.value;
                    }
                });

                // Event listeners for changes to checkbox (one)
                checkboxOne.forEach((checkbox) => {
                    checkbox.addEventListener('change', () => {
                        // Check the status of dropdown checkboxes
                        CheckCheckbox();
                    });
                });

                // Check dropdown checkboxes status
                function CheckCheckbox() {
                    // Get the number of checked checkbox (one)
                    const checkedCount = element.querySelectorAll('input[data-checkbox-type="one"]:checked').length;
                    // If all checkbox (one) are checked or none are checked
                    if (checkedCount === checkboxOne.length || checkedCount < 1) {
                        // Check the checkbox (all), uncheck checkbox (one), and update toggle button text
                        checkboxAll.checked = true;
                        checkboxOne.forEach((cb) => { cb.checked = false; });
                        spanSelected.textContent = checkboxAll.value;
                    } else {
                        // Uncheck the checkbox (all), get checked checkbox (one) values, and update toggle button text
                        checkboxAll.checked = false;
                        const checkedValues = [];
                        checkboxOne.forEach((cb) => {
                            if (cb.checked) {
                                checkedValues.push(cb.value);
                            }
                        });
                        spanSelected.textContent = checkedValues.join(', ');
                    }
                }

            });
        }
    },

    // CHANGE AVATAR
    changeAvatar: () => {

        // Get all elements with the data-user-avatar attribute
        const userAvatars = document.querySelectorAll('[data-user-avatar]');

        // Loop through each data-user-avatar element
        userAvatars.forEach((userAvatar) => {
            // Get the child elements inside the data-user-avatar element
            const inputAvatar = userAvatar.querySelector('[data-input-avatar]');
            const updateAvatarBtn = userAvatar.querySelector('[data-update-avatar]');
            const showAvatarImg = userAvatar.querySelector('[data-show-avatar]');

            // Check if the elements are found
            if (inputAvatar && updateAvatarBtn && showAvatarImg) {
                // Add an event listener to inputAvatar when its value changes
                inputAvatar.addEventListener('change', () => {
                    // Check if a file is selected
                    if (inputAvatar.files && inputAvatar.files[0]) {
                        // Get the file extension of the selected file
                        const fileExtension = inputAvatar.files[0].name.split('.').pop().toLowerCase();

                        // Check if the file extension is valid
                        if (['jpg', 'gif', 'png'].includes(fileExtension)) {
                            // Remove the d-none class from the updateAvatarBtn button
                            updateAvatarBtn.classList.remove('d-none');

                            // Change the source of the showAvatarImg element
                            const reader = new FileReader();
                            reader.addEventListener('load', () => {
                                showAvatarImg.src = reader.result;
                                showAvatarImg.srcset = reader.result;
                            });
                            reader.readAsDataURL(inputAvatar.files[0]);
                        } else {
                            // If the file extension is invalid, add the d-none class to the updateAvatarBtn button
                            updateAvatarBtn.classList.add('d-none');
                        }
                    } else {
                        // If no file is selected, add the d-none class to the updateAvatarBtn button
                        updateAvatarBtn.classList.add('d-none');
                    }
                });
            }
        });
    },

    // Range price
    rangePrice: () => {
        // Select all dropdown checkboxes
        document.querySelectorAll('[data-range-price]').forEach(function (element) {

            // Get references to the range input, price input, and slider elements
            const rangeInput = element.querySelectorAll(".range-input input");
            const priceInput = element.querySelectorAll(".price-input input");
            const range = element.querySelector(".slider .progress");

            // Set the minimum price gap
            let priceGap = 100;

            // Check if all necessary elements exist
            if (rangeInput && priceInput && range) {

                // Set up event listeners for price input fields
                priceInput.forEach(input => {
                    // When a price input field's value changes...
                    input.addEventListener("change", e => {
                        // Get the current min and max prices
                        let minPrice = parseInt(priceInput[0].value),
                            maxPrice = parseInt(priceInput[1].value);

                        // If the price range is valid...
                        if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
                            // If the first price input field was changed...
                            if (e.target === priceInput[0]) {
                                // Update the left range input field and the slider
                                rangeInput[0].value = minPrice;
                                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
                            } else {
                                // Otherwise, update the right range input field and the slider
                                rangeInput[1].value = maxPrice;
                                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                            }
                        }
                    });
                });

                // Set up event listeners for range input fields
                rangeInput.forEach(input => {
                    // When the range input fields change...
                    input.addEventListener("input", e => {
                        // Get the current min and max values
                        let minVal = parseInt(rangeInput[0].value),
                            maxVal = parseInt(rangeInput[1].value);

                        // If the price range is too small...
                        if ((maxVal - minVal) < priceGap) {
                            // If the first range input field was changed...
                            if (e.target.className === "range-min") {
                                // Enforce a minimum price gap
                                rangeInput[0].value = maxVal - priceGap
                            } else {
                                // Otherwise, enforce a minimum price gap from the other end
                                rangeInput[1].value = minVal + priceGap;
                            }
                        } else {
                            // Otherwise, update the price input fields and the slider
                            priceInput[0].value = minVal;
                            priceInput[1].value = maxVal;
                            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                            range.style.right = 100 - ((maxVal / rangeInput[1].max) * 100) + "%";
                        }
                    });
                });

                // Set the initial positions of the slider's progress bar
                const minVal = parseInt(rangeInput[0].value);
                const maxVal = parseInt(rangeInput[1].value);
                range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                range.style.right = 100 - ((maxVal / rangeInput[1].max) * 100) + "%";
            }

        });
    },

    // SWICH THEME MODE
    // https://getbootstrap.com/docs/5.3/customize/color-modes/
    switchMode: () => {
        const storedTheme = localStorage.getItem('theme')

        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }

            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }

        const setTheme = function (theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }

        setTheme(getPreferredTheme())

        const showActiveTheme = (theme, focus = false) => {
            const themeSwitcher = document.querySelector('#bd-theme')

            if (!themeSwitcher) {
                return
            }

            const themeSwitcherText = document.querySelector('#bd-theme-text')
            const activeThemeIcon = document.querySelector('.theme-icon-active use')
            const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
            const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

            document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                element.classList.remove('active')
                element.setAttribute('aria-pressed', 'false')
            })

            btnToActive.classList.add('active')
            btnToActive.setAttribute('aria-pressed', 'true')
            activeThemeIcon.setAttribute('href', svgOfActiveBtn)
            const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
            themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

            if (focus) {
                themeSwitcher.focus()
            }
        }

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (storedTheme !== 'light' || storedTheme !== 'dark') {
                setTheme(getPreferredTheme())
            }
        })

        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-bs-theme-value]').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const theme = toggle.getAttribute('data-bs-theme-value')
                localStorage.setItem('theme', theme)
                setTheme(theme)
                showActiveTheme(theme, true)
            })
        })

        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        const toggleThemeButton = document.querySelector('#toggle-theme');

        if (toggleThemeButton) {
            const toggleThemeIcon = toggleThemeButton.querySelector('i');

            toggleThemeButton.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                updateToggleThemeIcon(newTheme);
            });

            const updateToggleThemeIcon = (theme) => {
                if (toggleThemeIcon) {
                    if (theme === 'dark') {
                        toggleThemeIcon.classList.remove('ti-sun');
                        toggleThemeIcon.classList.add('ti-moon');
                    } else {
                        toggleThemeIcon.classList.remove('ti-moon');
                        toggleThemeIcon.classList.add('ti-sun');
                    }
                }
            }
            updateToggleThemeIcon(currentTheme);

        }
    },

    //CHANGE THEME COLOR
    changeThemeColor: () => {
        // Select all elements with the attribute 'data-theme-color-toggle'
        const colorToggles = document.querySelectorAll('[data-theme-color-toggle]');

        // Add an event listener to each element
        colorToggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                // Get the value of the 'data-theme-color-toggle' attribute
                const color = toggle.getAttribute('data-theme-color-toggle');
                // Create a new link element
                const link = document.createElement('link');
                // Set the href attribute to point to the corresponding CSS file
                link.setAttribute('href', `./assets/css/colors/${color}.css`);
                // Set the rel attribute to 'stylesheet'
                link.setAttribute('rel', 'stylesheet');
                // Append the link element to the head of the document
                document.head.appendChild(link);
                // Store the selected color theme in a cookie
                document.cookie = `color=${color}; path=/`;

                // Remove the 'selected' class from all elements
                colorToggles.forEach(toggle => toggle.classList.remove('selected'));

                // Add the 'selected' class to the clicked element
                toggle.classList.add('selected');
            });
        });

        // Add an event listener to the window load event
        window.addEventListener('load', () => {
            // Split the document.cookie string into an array of cookies
            const cookies = document.cookie.split('; ');
            // Find the 'color' cookie
            const colorCookie = cookies.find(cookie => cookie.startsWith('color='));
            if (colorCookie) {
                // Get the value of the 'color' cookie
                const color = colorCookie.split('=')[1];
                // Create a new link element
                const link = document.createElement('link');
                // Set the href attribute to point to the corresponding CSS file
                link.setAttribute('href', `./assets/css/colors/${color}.css`);
                // Set the rel attribute to 'stylesheet'
                link.setAttribute('rel', 'stylesheet');
                // Append the link element to the head of the document
                document.head.appendChild(link);

                // Select the element with the matching 'data-theme-color-toggle' attribute value
                const selectedToggle = document.querySelector(`[data-theme-color-toggle="${color}"]`);
                if (selectedToggle) {
                    // Add the 'selected' class to this element
                    selectedToggle.classList.add('selected');
                }
            }
        });

    },

    // COUNTDOWN
    // assets/css/vender/countdown.min.css
    // assets/css/vender/countdown.min.js
    countdown: () => {
        const countdownEl = document.querySelector('.countdown');
        if (countdownEl) {
            const countdown_timer = new countdown({
                target: '.countdown',
                dayWord: 'days',
                hourWord: 'hours',
                minWord: 'mins',
                secWord: 'secs'
            });
        }
    },

    // ANIMATION - SCROLLCUE
    // assets/css/vender/scrollcue.min.css
    // assets/css/vender/scrollcue.min.js
    scrollCue: () => {
        scrollCue.init({
            interval: -500,
            duration: 600,
            percentage: 0.55
        });
        scrollCue.update();
    },

    // BOOTSTRAP DSELECT
    // assets/css/vender/dselect.min.css
    // assets/css/vender/dselect.min.js
    // https://github.com/jarstone/dselect
    dSelect: () => {
        for (const el of document.querySelectorAll('.dselect')) {
            dselect(el)
        }
    },

    // DATEPICKER
    // assets/js/vender/flatpickr.min.css
    // assets/js/vender/flatpickr.min.js
    // https://github.com/flatpickr/flatpickr
    datePicker: () => {

        // Date of birth
        new flatpickr(".date-of-birth", {
            allowInput: true,
            minDate: "today",
            static: true,
            position: "right center",
            wrap: true,
            disableMobile: "true",
            dateFormat: "M d, Y",
        });

        // Departure -date
        new flatpickr(".departure-date", {
            allowInput: true,
            minDate: "today",
            static: true,
            position: "right center",
            wrap: true,
            disableMobile: "true",
            dateFormat: "M d, Y",
        });

    },

    // SWIPER SLIDER
    // assets/css/vender/swiper-bundle.min.css
    // assets/js/vender/swiper-bundle.min.js
    // https://github.com/nolimits4web/swiper
    swiperSlider: () => {

        //
        if (document.querySelector('.hero-slider')) {
            var swiper = new Swiper(".hero-slider", {
                slidesPerView: 1,
                spaceBetween: 24,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.hero-next',
                    prevEl: '.hero-prev',
                },
                pagination: {
                    el: '.hero-pagination',
                    type: 'fraction',
                },
            });
        }

        // Adventure type slider
        if (document.querySelector('.adventure-type-slider')) {
            new Swiper(".adventure-type-slider", {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.adventure-type-next',
                    prevEl: '.adventure-type-prev',
                },
                pagination: {
                    el: ".adventure-type-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    1300: {
                        slidesPerView: 5,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                }
            });
        }

        // Special offers slider
        if (document.querySelector('.special-offer-slider')) {
            new Swiper(".special-offer-slider", {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.special-offer-next',
                    prevEl: '.special-offer-prev',
                },
                pagination: {
                    el: ".special-offer-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    1300: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                }
            });
        }

        // Special offers slider
        if (document.querySelector('.special-related-slider')) {
            new Swiper(".special-related-slider", {
                slidesPerView: 1,
                spaceBetween: 16,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.special-related-next',
                    prevEl: '.special-related-prev',
                },
                pagination: {
                    el: ".special-related-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    1300: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                }
            });
        }

        // client review slider
        if (document.querySelector('.client-review-slider')) {
            new Swiper(".client-review-slider", {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.client-review-next',
                    prevEl: '.client-review-prev',
                },
                pagination: {
                    el: ".client-review-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 0,
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                }
            });
        }


        // Special offers slider
        if (document.querySelector('.related-post-slider')) {
            new Swiper(".related-post-slider", {
                slidesPerView: 1,
                spaceBetween: 16,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.related-post-next',
                    prevEl: '.related-post-prev',
                },
                pagination: {
                    el: ".related-post-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    1300: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                }
            });
        }


        // Adventure type slider
        if (document.querySelector('.team-slider')) {
            new Swiper(".team-slider", {
                slidesPerView: 1,
                spaceBetween: 32,
                speed: 800,
                loop: true,
                navigation: {
                    nextEl: '.team-next',
                    prevEl: '.team-prev',
                },
                pagination: {
                    el: ".team-pagination",
                    type: "fraction",
                },
                breakpoints: {
                    1300: {
                        slidesPerView: 4,
                        spaceBetween: 32,
                    },
                    1120: {
                        slidesPerView: 4,
                        spaceBetween: 32,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 32,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 32,
                    },
                }
            });
        }

    },

    // PLYR PLAYER
    // assets/css/vender/plyr.min.css
    // assets/css/vender/plyr.min.js
    // https://github.com/sampotts/plyr
    plyrPlayer: () => {
        // Create a new Plyr object for the html5 video
        const html5Player = new Plyr('.html5-player');
        // Create a new Plyr object for the vimeo video
        const vimeoPlayer = new Plyr('.vimeo-player');
        // Create a new Plyr object for the youtube video
        const youtubePlayer = new Plyr('.youtube-player');
    },

    // GLIGHTBOX
    // assets/css/vender/glightbox.min.css
    // assets/css/vender/glightbox.min.js
    // https://github.com/biati-digital/glightbox
    // assets/css/vender/plyr.min.css
    // assets/css/vender/plyr.min.js
    // https://github.com/sampotts/plyr
    gLightbox: () => {
        // Create a new GLightbox object for elements with the '.glightbox' class
        let photoLightbox = GLightbox({
            selector: '.glightbox'
        });

        // Create a new GLightbox object for elements with the '.media-glightbox' class
        let mediaLightbox = GLightbox({
            selector: '.media-glightbox',
            touchNavigation: true,
            loop: false,
            zoomable: false,
            autoplayVideos: true,
            moreLength: 0,
            slideExtraAttributes: {
                poster: ''
            },
            // Set options for the Plyr player
            plyr: {
                config: {
                    ratio: '16:9',
                    muted: false,
                    hideControls: true,
                    youtube: {
                        noCookie: false,
                        rel: 0,
                        showinfo: 0,
                        iv_load_policy: 3
                    },
                    vimeo: {
                        byline: false,
                        portrait: false,
                        title: false,
                        speed: true,
                        transparent: false
                    }
                }
            },
        });
    },

    // BOOTSTRAP VALIDATION
    // https://getbootstrap.com/docs/5.3/forms/validation/#how-it-works
    bsValidation: () => {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    },

    // HIGHLIGHT
    // assets/css/vender/highlight-dark.min.css
    // assets/css/vender/highlight.min.js
    // https://github.com/highlightjs/highlight.js
    highlight: () => {
        hljs.highlightAll();
    },

    // CODE SNIPPET
    // assets/css/vender/clipboard.min.js
    // https://github.com/zenorocha/clipboard.js
    codeSnippet: () => {
        // Define the HTML for the copy button
        var btnHtml = '<button type="button" class="btn btn-sm btn-light btn-clipboard">Copy</button>'

        // Select all elements with the class 'code-wrapper-inner'
        document.querySelectorAll('.code-wrapper-inner').forEach(function (element) {
            // Insert the copy button HTML before each selected element
            element.insertAdjacentHTML('beforebegin', btnHtml)
        })

        // Create a new ClipboardJS instance for elements with the class 'btn-clipboard'
        var clipboard = new ClipboardJS('.btn-clipboard', {
            // Set the target to be the next sibling element of the trigger element
            target: function (trigger) {
                return trigger.nextElementSibling
            }
        })

        // Add an event listener for successful copy events
        clipboard.on('success', event => {
            // Change the text of the trigger element to 'Copied!'
            event.trigger.textContent = 'Copied!';
            // Clear the selection
            event.clearSelection();
            // Set a timeout to change the text of the trigger element back to 'Copy' after 2000ms
            setTimeout(function () {
                event.trigger.textContent = 'Copy';
            }, 2000);
        });

        // Create a new ClipboardJS instance for elements with the class 'btn-copy-icon'
        var copyIconCode = new ClipboardJS('.btn-copy-icon');

        // Add an event listener for successful copy events
        copyIconCode.on('success', function (event) {
            // Clear the selection
            event.clearSelection();
            // Change the text of the trigger element to 'Copied!'
            event.trigger.textContent = 'Copied!';
            // Set a timeout to change the text of the trigger element back to 'Copy' after 2300ms
            window.setTimeout(function () {
                event.trigger.textContent = 'Copy';
            }, 2300);
        });
    },

    // PRELOAD
    preloader: () => {
        // Select the preloader element
        const preloader = document.querySelector('#preloader');

        // Check if the preloader element exists
        if (preloader) {
            // Define a function to remove the preloader
            function removePreloader() {
                // Remove the preloader element from the DOM
                preloader.remove();
                // Remove classes from the body element
                document.body.classList.remove('vh-100', 'vw-100', 'overflow-hidden');
            }

            // Set a timeout to call the removePreloader function after 1500ms
            setTimeout(() => {
                // Use requestAnimationFrame to call the removePreloader function
                window.requestAnimationFrame(removePreloader);
            }, 1500);
        }
    },
}

// DOM fully loaded
document.addEventListener("DOMContentLoaded", (event) => {
    theme.init();
});


