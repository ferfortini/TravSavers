$('.experience').each(function () {
    $(this).on('click', function () {
        const self = $(this);
        const modalBody = $('#customValueModal .modal-body');
        const modalTitle = $('#customValueModal .modal-title');
        const submitButton = $('#customValueModal button[name="submitExperienceBtn"]');

        modalBody.html(`
            <form class="row g-3 mt-1" id="addEditExperienceForm">
            <input type="hidden" name="experience_id" id="experience_id" value="${self.data('id')}">
            <div class="col-md-12 mb-1">
                <label class="form-label" for="value">Experience name</label>
                <input type="text" class="form-control experience-name" name="name" id="edit-experience-name" value="${self.data('name')}" placeholder="">
               <div class="invalid-feedback experience-name-error" id="experience-name-error"></div>
            </div>
            <div class="col-md-12 text-end mt-md-4">
                <button class="btn btn-info" type="submit" id="submitExperienceBtn" name="submitExperienceBtn">Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i></button>
                <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
            </div>
            </form>
        `);

        modalTitle.text(`Edit ${self.data('title')}`);
        submitButton.text(`Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i>`);
    });
});

$('.experienceType').each(function () {
    $(this).on('click', function () {
        const self = $(this);
        const modalBody = $('#customValueModal .modal-body');
        const modalTitle = $('#customValueModal .modal-title');
        const submitButton = $('#customValueModal button[name="submitExperienceTypeBtn"]');

        modalBody.html(`
        <form class="row g-3 mt-1" id="addEditExperienceTypeForm">
          <input type="hidden" name="experience_type_id" id="experience_type_id" value="${self.data('id')}">
          <div class="col-md-12 mb-1">
            <label class="form-label" for="value">Experience Type name</label>
            <input type="text" class="form-control experience-type-name" name="name" value="${self.data('name')}" placeholder="">
            <div class="invalid-feedback experience-type-name-error"></div>
          </div>
          <div class="col-md-12 text-end mt-md-4">
            <button class="btn btn-info" type="submit" id="submitExperienceTypeBtn" name="submitExperienceTypeBtn">Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i></button>
            <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
          </div>
        </form>
      `);

        modalTitle.text(`Edit ${self.data('title')}`);
        submitButton.text(`Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i>`);
    });
});

$('.rate').each(function () {
    $(this).on('click', function () {
        const self = $(this);
        const modalBody = $('#customValueModal .modal-body');
        const modalTitle = $('#customValueModal .modal-title');
        const submitButton = $('#customValueModal button[name="submitRateBtn"]');

        modalBody.html(`
            <form class="row g-3 mt-1" id="rateForm">
            <input type="hidden" name="rate_id" id="rate_id" value="${self.data('id')}">
            <div class="col-md-12 mb-1">
                <label class="form-label">Type</label>
                <select class="form-select form-select-sm js-choice border-0 type" name="type" id="editType">
                    <option value="" selected disabled>Choose:</option>
                    <option value="Text">Text</option>
                    <option value="USD">USD</option>
                </select>
                <div class="invalid-feedback type-error"></div>
            </div>
            <div class="col-md-12 mb-1">
                <label class="form-label" for="value">Value</label>
                <input type="text" class="form-control value" name="value" id="editRateValue" value="${self.data('name')}" placeholder="">
                <div class="invalid-feedback value-error"></div>
            </div>
            <div class="col-md-12 text-end mt-md-4">
                <button class="btn btn-info" type="submit" id="submitRateBtn" name="submitRateBtn">Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i></button>
                <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
            </div>
            </form>
      `);

        modalTitle.text(`Edit ${self.data('title')}`);
        submitButton.text(`Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i>`);
        const type = self.data('type');
        updateChoice("editType", type);
    });
});

$(document).on('click', '.hotel', function () {
    const self = $(this);
    const modalBody = $('#customValueModal .modal-body');
    const modalTitle = $('#customValueModal .modal-title');
    const submitButton = $('#customValueModal button[name="hotel_submit"]');

    modalBody.html(`
            <form class="row g-3 mt-1" id="hotelForm" enctype="multipart/form-data">
                <input type="hidden" name="hotel_id" id="hotel_id" value="${self.data('id')}">
                        <div class="col-md-8">
                            <label class="form-label" for="hotelName">Hotel Name</label>
                            <input type="text" class="form-control hotelName" name="hotelName" id="hotelName" value="${self.data('name')}" placeholder="">
                            <div class="invalid-feedback hotelName-error"></div>
                        </div>
                          <div class="col-md-4">
                            <label for="starRating" class="form-label">Star Rating</label>
                            <select class="form-select js-choice border-0 starRating" name="starRating" id="editRating">
                                <option value="" disabled selected>Select:</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <div class="invalid-feedback starRating-error"></div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="chooseCountry">Country</label>
                            <select class="form-select form-select-sm js-choice border-0 hotelCountry" name="hotelCountry" id="editHotelCountry">
                                <option value="" selected disabled>Select:</option>
                                <option value="united_states">United States</option>
                                <option value="mexico">Mexico</option>
                                <option value="united_kingdom">United Kingdom</option>
                                <option value="afghanistan">Afghanistan</option>
                                <option value="albania">Albania</option>
                                <option value="algeria">Algeria</option>
                                <option value="andorra">Andorra</option>
                                <option value="angola">Angola</option>
                                <option value="antigua_and_barbuda">Antigua and Barbuda</option>
                                <option value="argentina">Argentina</option>
                                <option value="armenia">Armenia</option>
                                <option value="australia">Australia</option>
                                <option value="austria">Austria</option>
                                <option value="azerbaijan">Azerbaijan</option>
                                <option value="bahamas">Bahamas</option>
                                <option value="bahrain">Bahrain</option>
                                <option value="bangladesh">Bangladesh</option>
                                <option value="barbados">Barbados</option>
                                <option value="belarus">Belarus</option>
                                <option value="belgium">Belgium</option>
                                <option value="belize">Belize</option>
                                <option value="benin">Benin</option>
                                <option value="bhutan">Bhutan</option>
                                <option value="bolivia">Bolivia</option>
                                <option value="bosnia_and_herzegovina">Bosnia and Herzegovina</option>
                                <option value="botswana">Botswana</option>
                                <option value="brazil">Brazil</option>
                                <option value="brunei">Brunei</option>
                                <option value="bulgaria">Bulgaria</option>
                                <option value="burkina_faso">Burkina Faso</option>
                                <option value="burundi">Burundi</option>
                                <option value="cabo_verde">Cabo Verde</option>
                                <option value="cambodia">Cambodia</option>
                                <option value="cameroon">Cameroon</option>
                                <option value="canada">Canada</option>
                                <option value="central_african_republic">Central African Republic</option>
                                <option value="chad">Chad</option>
                                <option value="chile">Chile</option>
                                <option value="china">China</option>
                                <option value="colombia">Colombia</option>
                                <option value="comoros">Comoros</option>
                                <option value="congo_(congo-brazzaville)">Congo (Congo-Brazzaville)</option>
                                <option value="congo_(democratic_republic)">Congo (Democratic Republic)</option>
                                <option value="costa_rica">Costa Rica</option>
                                <option value="côte_d'Ivoire">Côte d'Ivoire</option>
                                <option value="croatia">Croatia</option>
                                <option value="cuba">Cuba</option>
                                <option value="cyprus">Cyprus</option>
                                <option value="czechia_(czech_republic)">Czechia (Czech Republic)</option>
                                <option value="denmark">Denmark</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="dominica">Dominica</option>
                                <option value="dominican_republic">Dominican Republic</option>
                                <option value="ecuador">Ecuador</option>
                                <option value="egypt">Egypt</option>
                                <option value="el_salvador">El Salvador</option>
                                <option value="equatorial_guinea">Equatorial Guinea</option>
                                <option value="eritrea">Eritrea</option>
                                <option value="estonia">Estonia</option>
                                <option value="eswatini">Eswatini</option>
                                <option value="ethiopia">Ethiopia</option>
                                <option value="fiji">Fiji</option>
                                <option value="finland">Finland</option>
                                <option value="france">France</option>
                                <option value="gabon">Gabon</option>
                                <option value="gambia">Gambia</option>
                                <option value="georgia">Georgia</option>
                                <option value="germany">Germany</option>
                                <option value="ghana">Ghana</option>
                                <option value="greece">Greece</option>
                                <option value="grenada">Grenada</option>
                                <option value="guatemala">Guatemala</option>
                                <option value="guinea">Guinea</option>
                                <option value="guinea_bissau">Guinea-Bissau</option>
                                <option value="guyana">Guyana</option>
                                <option value="haiti">Haiti</option>
                                <option value="honduras">Honduras</option>
                                <option value="hungary">Hungary</option>
                                <option value="iceland">Iceland</option>
                                <option value="india">India</option>
                                <option value="indonesia">Indonesia</option>
                                <option value="iran">Iran</option>
                                <option value="iraq">Iraq</option>
                                <option value="ireland">Ireland</option>
                                <option value="israel">Israel</option>
                                <option value="italy">Italy</option>
                                <option value="jamaica">Jamaica</option>
                                <option value="japan">Japan</option>
                                <option value="jordan">Jordan</option>
                                <option value="kazakhstan">Kazakhstan</option>
                                <option value="kenya">Kenya</option>
                                <option value="kiribati">Kiribati</option>
                                <option value="korea_(north)">Korea (North)</option>
                                <option value="korea_(south)">Korea (South)</option>
                                <option value="kuwait">Kuwait</option>
                                <option value="kyrgyzstan">Kyrgyzstan</option>
                                <option value="laos">Laos</option>
                                <option value="latvia">Latvia</option>
                                <option value="lebanon">Lebanon</option>
                                <option value="lesotho">Lesotho</option>
                                <option value="liberia">Liberia</option>
                                <option value="libya">Libya</option>
                                <option value="liechtenstein">Liechtenstein</option>
                                <option value="lithuania">Lithuania</option>
                                <option value="luxembourg">Luxembourg</option>
                                <option value="madagascar">Madagascar</option>
                                <option value="malawi">Malawi</option>
                                <option value="malaysia">Malaysia</option>
                                <option value="maldives">Maldives</option>
                                <option value="mali">Mali</option>
                                <option value="malta">Malta</option>
                                <option value="marshall_islands">Marshall Islands</option>
                                <option value="mauritania">Mauritania</option>
                                <option value="mauritius">Mauritius</option>
                                <option value="micronesia">Micronesia</option>
                                <option value="moldova">Moldova</option>
                                <option value="monaco">Monaco</option>
                                <option value="mongolia">Mongolia</option>
                                <option value="montenegro">Montenegro</option>
                                <option value="morocco">Morocco</option>
                                <option value="mozambique">Mozambique</option>
                                <option value="myanmar_(burma)">Myanmar (Burma)</option>
                                <option value="namibia">Namibia</option>
                                <option value="nauru">Nauru</option>
                                <option value="nepal">Nepal</option>
                                <option value="netherlands">Netherlands</option>
                                <option value="new_zealand">New Zealand</option>
                                <option value="nicaragua">Nicaragua</option>
                                <option value="niger">Niger</option>
                                <option value="nigeria">Nigeria</option>
                                <option value="north_macedonia">North Macedonia</option>
                                <option value="norway">Norway</option>
                                <option value="oman">Oman</option>
                                <option value="pakistan">Pakistan</option>
                                <option value="palau">Palau</option>
                                <option value="panama">Panama</option>
                                <option value="papua_new_guinea">Papua New Guinea</option>
                                <option value="paraguay">Paraguay</option>
                                <option value="peru">Peru</option>
                                <option value="philippines">Philippines</option>
                                <option value="poland">Poland</option>
                                <option value="portugal">Portugal</option>
                                <option value="qatar">Qatar</option>
                                <option value="romania">Romania</option>
                                <option value="russia">Russia</option>
                                <option value="rwanda">Rwanda</option>
                                <option value="saint_kitts_and_nevis">Saint Kitts and Nevis</option>
                                <option value="saint_lucia">Saint Lucia</option>
                                <option value="saint_Vincent_and_the_grenadines">Saint Vincent and the Grenadines</option>
                                <option value="samoa">Samoa</option>
                                <option value="san_marino">San Marino</option>
                                <option value="sao_tome_and_principe">Sao Tome and Principe</option>
                                <option value="saudi_arabia">Saudi Arabia</option>
                                <option value="senegal">Senegal</option>
                                <option value="serbia">Serbia</option>
                                <option value="seychelles">Seychelles</option>
                                <option value="sierra Leone">Sierra Leone</option>
                                <option value="singapore">Singapore</option>
                                <option value="slovakia">Slovakia</option>
                                <option value="slovenia">Slovenia</option>
                                <option value="solomon_islands">Solomon Islands</option>
                            </select>
                            <div class="invalid-feedback hotelCountry-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control address" name="address" id="address" value="${self.data('address')}" placeholder="">
                            <div class="invalid-feedback address-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="hotelCity">City</label>
                            <input type="text" class="form-control hotelCity" name="hotelCity" id="hotelCity" value="${self.data('city')}" placeholder="">
                            <div class="invalid-feedback hotelCity-error"></div>
                        </div>

                        <div class="col-md-4 mb-1">
                            <label class="form-label">State</label>
                            <select class="form-select form-select-sm js-choice border-0 hotelState" name="hotelState" id="editHotelState">
                                <option value="" selected disabled>Select</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DR">Dominican Republic</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="PC">Playa Confresi</option>
                                <option value="PP">Puerto Plata</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                            <div class="invalid-feedback hotelState-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="city">ZIP</label>
                            <input type="text" class="form-control zip" name="zip" id="zip" value="${self.data('zip')}" placeholder="">
                             <div class="invalid-feedback zip-error"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="amenities">Amenities</label>
                            <input type="text" class="form-select form-select-sm js-choice border-0 amenities"  id="editAmenities" name="amenities[]" data-placeholder-val="Begin typing to create amenities list." value="${self.data('amenities')}" >
                            <div class="invalid-feedback amenities-error"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="hotelImage">Hotel image(s)</label>
                            <input type="hidden" name="existingImage" class="existingImage" value="">
                            <input class="form-control hotelImage" type="file" name="hotelImage[]" id="hotelEditImage" multiple>
                            <div class="form-text">(Image types: .jpg, .jpeg, .png)</div>
                            <div id="editHotelImagePreview" class="mt-2 d-flex gap-2 overflow-auto"></div>
                            <div class="invalid-feedback hotelImage-error"></div>
                        </div>
                        
                        <div class="col-md-12 text-end mt-md-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss ="modal">Close</button>
                            <button class="btn btn-info" type="submit" name="hotel_submit">Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
        `);

    modalTitle.text(`Edit ${self.data('title')}`);
    submitButton.text(`Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i>`);
    updateChoice("editHotelCountry", $(this).data('country'));
    updateChoice("editHotelState", $(this).data('state'));
    updateChoice("editAmenities", $(this).data('amenities'));
    updateChoice("editRating", $(this).data('rating'));

    const imageUrl = self.data('image'); // Assuming this contains the existing image URLs
    loadExistingImages(imageUrl, 'edit', '#editHotelImagePreview');

    let selectedFiles = [];
    let removedExistingIndexes = [];

    $('#hotelEditImage').on('change', function () {
        const input = this;
        const previewContainer = $('#editHotelImagePreview');
        const errorDiv = $(this).siblings('.hotelImage-error');
        let hasInvalidFile = false;
        const maxImages = 8;

        // Clear previous error
        errorDiv.text('');

        if (input.files && input.files.length > 0) {
            const files = Array.from(input.files);

            // Check total number of images (existing + new)
            const totalImages = (imageUrl ? imageUrl.split(',').length : 0) + files.length;
            if (totalImages > maxImages) {
                hasInvalidFile = true;
                errorDiv.text(`You can only select up to ${maxImages} images total.`);
                this.value = '';
                return;
            }

            // Validate each file
            files.forEach(file => {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    hasInvalidFile = true;
                    errorDiv.text(`Invalid file type: ${file.name}. Only JPEG, JPG, and PNG files are allowed.`);
                    return;
                }

                if (file.size > 1 * 1024 * 1024) {
                    hasInvalidFile = true;
                    errorDiv.text(`File too large: ${file.name}. Maximum size is 1MB.`);
                    return;
                }
            });

            if (hasInvalidFile) {
                this.value = '';
                selectedFiles = [];
                previewContainer.empty();
                return;
            }
        }

        previewContainer.empty();
        selectedFiles = [];

        // Preview existing images (if still needed)
        if (imageUrl) {
            const existingUrls = imageUrl.split(',').map(url => url.trim());
            existingUrls.forEach((url, idx) => {
                const imgContainer = $('<div>', {
                    class: 'img-container position-relative d-flex m-2',
                    'data-existing-index': idx
                });

                const img = $('<img>', {
                    src: `uploads/hotel_images/${url}`,
                    class: 'img-fluid',
                    style: 'height: 100px; width: auto;'
                });

                const closeBtn = $('<span>', {
                    class: 'close-btn',
                    text: '×',
                    role: 'button',
                    tabindex: 0,
                });

                closeBtn.on('click keydown', function (event) {
                    if (event.type === 'click' || event.key === 'Enter' || event.key === ' ') {
                        $(imgContainer).remove();
                        removedExistingIndexes.push(idx);
                    }
                });

                imgContainer.append(img).append(closeBtn);
                previewContainer.append(imgContainer);
            });
        }

        // Preview new uploaded images
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgContainer = $('<div>', {
                        class: 'img-container position-relative d-inline-block m-2'
                    });

                    const img = $('<img>', {
                        src: e.target.result,
                        class: 'img-fluid',
                        style: 'height: 100px; width: auto;'
                    });

                    const closeBtn = $('<span>', {
                        class: 'close-btn',
                        text: '×',
                        role: 'button',
                        tabindex: 0,
                    });

                    closeBtn.on('click keydown', function (event) {
                        if (event.type === 'click' || event.key === 'Enter' || event.key === ' ') {
                            $(imgContainer).remove();
                            selectedFiles.splice(index, 1); // Remove from selected files
                        }
                    });

                    imgContainer.append(img).append(closeBtn);
                    previewContainer.append(imgContainer);
                };
                reader.readAsDataURL(file);
                selectedFiles.push(file); // Track new files
            });
        }
    });

});

//Show hotel details
$(document).on('click', '.hotelDetails', function () {
    const hotelId = $(this).data('id');
    const modalBody = $('#hotelViewModal .modal-body');
    $.ajax({
        type: 'POST',
        url: 'hotel-data.php',
        data: { hotelId: hotelId },
        success: function (data) {
            const hotelData = data?.data;
            // Generate amenities HTML
            let amenitiesHtml = '';
            if (hotelData?.amenities && Array.isArray(hotelData.amenities)) {
                hotelData.amenities.forEach(function (amenity) {
                    amenitiesHtml += `<li class="list-inline-item badge bg-secondary me-1">${amenity}</li>`;
                });
            }

            // Generate images HTML
            let imagesHtml = '';
            if (hotelData?.images) {
                hotelData?.images.forEach(function (imageUrl) {
                    if (imageUrl) {
                        imagesHtml += `<img src="uploads/hotel_images/${imageUrl}" alt="Hotel Image" class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">`;
                    }
                });
            }

            modalBody.html(`
                <div class="row mb-3">
                  <div class="col-md-6"><strong>Hotel Name:</strong> <span id="viewHotelName">${hotelData?.name || ''}</span></div>
                  <div class="col-md-6"><strong>Star Rating:</strong> <span class="text-warning fw-semibold" id="viewStarRating">
                    ${'★'.repeat(hotelData?.rating || 0)}
                    </span></div>
                </div>
          
                <div class="row mb-3">
                  <div class="col-md-6"><strong>Country:</strong> <span id="viewCountry">${hotelData?.country ? hotelData.country.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : ''}</span></div>
                  <div class="col-md-6"><strong>Address:</strong> <span id="viewAddress">${hotelData?.address || ''}</span></div>
                </div>
          
                <div class="row mb-3">
                  <div class="col-md-4"><strong>City:</strong> <span id="viewCity">${hotelData?.city || ''}</span></div>
                  <div class="col-md-4"><strong>State:</strong> <span id="viewState">${hotelData?.state || ''}</span></div>
                  <div class="col-md-4"><strong>ZIP:</strong> <span id="viewZip">${hotelData?.zip || ''}</span></div>
                </div>
          
                <div class="mb-3">
                    <strong>Amenities:</strong>
                    <ul id="viewAmenities" class="list-inline">
                        ${amenitiesHtml}
                    </ul>
                </div>
          
                <div class="mb-3">
                  <strong>Hotel Image(s):</strong>
                  <div id="viewHotelImages" class="d-flex flex-wrap gap-2 mt-2">
                    ${imagesHtml}
                  </div>
                </div>
          
                <div class="text-end">
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              `);
        }
    });
});


// Array holding newly selected files (File objects)
let selectedFiles = [];
// Array holding existing image URLs (strings)
let existingImages = [];

// Update preview: show both existing and newly added images
function updatePreview(mode = 'add', containerId = null) {
    const previewContainer = containerId ? $(containerId) : $('#hotelImagePreview');
    previewContainer.empty();

    if (mode === 'edit') {
        // Show existing images first for edit mode
        existingImages.forEach((url, idx) => {
            const imgContainer = $('<div>', { class: 'img-container', 'data-existing-index': idx });
            const img = $('<img>', { src: `uploads/hotel_images/${url}`, alt: 'Existing hotel image preview' });
            const closeBtn = $('<span>', {
                class: 'close-btn',
                text: '×',
                role: 'button',
                tabindex: 0
            });

            closeBtn.on('click keydown', function (event) {
                if (event.type === 'click' || event.key === 'Enter' || event.key === ' ') {
                    removeExistingImage(idx, mode, containerId);

                    $.ajax({
                        url: 'services/delete-hotel-image.php',
                        type: 'POST',
                        data: {
                            image: url,
                            hotelId: $("#hotel_id").val()
                        },
                        success: function (response) {
                            if (response.success) {
                                imgContainer.empty();
                                previewContainer.empty();
                            }
                        }
                    });
                }
            });

            imgContainer.append(img).append(closeBtn);
            previewContainer.append(imgContainer);
        });
    }

    // Show new selected files
    selectedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imgContainer = $('<div>', { class: 'img-container', 'data-new-index': idx });
            const img = $('<img>', { src: e.target.result, alt: 'Uploaded hotel image preview' });
            const closeBtn = $('<span>', {
                class: 'close-btn',
                text: '×',
                role: 'button',
                tabindex: 0
            });

            closeBtn.on('click keydown', function (event) {
                if (event.type === 'click' || event.key === 'Enter' || event.key === ' ') {
                    removeNewImage(idx, mode, containerId);
                }
            });

            imgContainer.append(img).append(closeBtn);
            previewContainer.append(imgContainer);
        };
        reader.readAsDataURL(file);
    });
}

// Remove an existing image from display & mark for deletion if needed
function removeExistingImage(index, mode, containerId) {
    existingImages.splice(index, 1);
    updatePreview(mode, containerId);
}

// Remove a newly added file and update input
function removeNewImage(index, mode, containerId) {
    selectedFiles.splice(index, 1);
    updateInputFiles();
    updatePreview(mode, containerId);
}

// Update the file input's FileList to reflect selectedFiles array
function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    $('#hotelImage')[0].files = dataTransfer.files;
}

// Load existing images from a string of URLs separated by commas
function loadExistingImages(imageUrlString, mode = 'add', containerId = null) {
    existingImages = [];
    if (imageUrlString) {
        const urls = imageUrlString.split(',').map(u => u.trim()).filter(u => u.length);
        // Full URLs for existing images are expected
        existingImages = urls;
    }
    updatePreview(mode, containerId);
}

// On file input change, add to selectedFiles and preview
$('#hotelImage').on('change', function () {
    const files = Array.from(this.files);
    const errorDiv = $(this).siblings('.hotelImage-error');
    let hasInvalidFile = false;
    const maxImages = 8;

    if (files.length > maxImages) {
        hasInvalidFile = true;
        errorDiv.text(`You can only select up to 8 images.`);
        return;
    }
    files.forEach(file => {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            hasInvalidFile = true;
            errorDiv.text(`Invalid file type: ${file.name}. Only JPEG, JPG, and PNG files are allowed.`);
            return;
        }

        if (file.size > 1 * 1024 * 1024) {
            hasInvalidFile = true;
            errorDiv.text(`File too large: ${file.name}. Maximum size is 1MB.`);
            return;
        }
    });

    if (hasInvalidFile) {
        this.value = '';
        selectedFiles = [];
        updateInputFiles();
        updatePreview('add', '#hotelImagePreview');
        return;
    }

    // Append new files avoiding duplicates by name + size + lastModified
    files.forEach(newFile => {
        const exists = selectedFiles.some(file =>
            file.name === newFile.name && file.size === newFile.size && file.lastModified === newFile.lastModified
        );
        if (!exists) {
            selectedFiles.push(newFile);
        }
    });

    updateInputFiles();
    updatePreview('add', '#hotelImagePreview');

    // Clear error
    errorDiv.text('');
});

$(document).on('click', '.location', function () {
    const self = $(this);
    const modalBody = $('#customValueModal .modal-body');
    const modalTitle = $('#customValueModal .modal-title');
    const submitButton = $('#customValueModal button[name="submitLocationBtn"]');

    modalBody.html(`
            <form class="row g-3 mt-1"  method="post" id="addEditLocationForm">
            <input type="hidden" name="location_id" id="location_id" value="${self.data('id')}">
                <div class="col-md-12 mb-1">
                    <label for="chooseCountry">Country</label>
                    <select class="form-select form-select-sm js-choice border-0 country" name="country" id="editCountry">
                        <option value="" selected disabled>Select:</option>
                        <option value="united_states">United States</option>
                        <option value="mexico">Mexico</option>
                        <option value="united_kingdom">United Kingdom</option>
                        <option value="afghanistan">Afghanistan</option>
                        <option value="albania">Albania</option>
                        <option value="algeria">Algeria</option>
                        <option value="andorra">Andorra</option>
                        <option value="angola">Angola</option>
                        <option value="antigua_and_barbuda">Antigua and Barbuda</option>
                        <option value="argentina">Argentina</option>
                        <option value="armenia">Armenia</option>
                        <option value="australia">Australia</option>
                        <option value="austria">Austria</option>
                        <option value="azerbaijan">Azerbaijan</option>
                        <option value="bahamas">Bahamas</option>
                        <option value="bahrain">Bahrain</option>
                        <option value="bangladesh">Bangladesh</option>
                        <option value="barbados">Barbados</option>
                        <option value="belarus">Belarus</option>
                        <option value="belgium">Belgium</option>
                        <option value="belize">Belize</option>
                        <option value="benin">Benin</option>
                        <option value="bhutan">Bhutan</option>
                        <option value="bolivia">Bolivia</option>
                        <option value="bosnia_and_herzegovina">Bosnia and Herzegovina</option>
                        <option value="botswana">Botswana</option>
                        <option value="brazil">Brazil</option>
                        <option value="brunei">Brunei</option>
                        <option value="bulgaria">Bulgaria</option>
                        <option value="burkina_faso">Burkina Faso</option>
                        <option value="burundi">Burundi</option>
                        <option value="cabo_verde">Cabo Verde</option>
                        <option value="cambodia">Cambodia</option>
                        <option value="cameroon">Cameroon</option>
                        <option value="canada">Canada</option>
                        <option value="central_african_republic">Central African Republic</option>
                        <option value="chad">Chad</option>
                        <option value="chile">Chile</option>
                        <option value="china">China</option>
                        <option value="colombia">Colombia</option>
                        <option value="comoros">Comoros</option>
                        <option value="congo_(congo-brazzaville)">Congo (Congo-Brazzaville)</option>
                        <option value="congo_(democratic_republic)">Congo (Democratic Republic)</option>
                        <option value="costa_rica">Costa Rica</option>
                        <option value="côte_d'Ivoire">Côte d'Ivoire</option>
                        <option value="croatia">Croatia</option>
                        <option value="cuba">Cuba</option>
                        <option value="cyprus">Cyprus</option>
                        <option value="czechia_(czech_republic)">Czechia (Czech Republic)</option>
                        <option value="denmark">Denmark</option>
                        <option value="djibouti">Djibouti</option>
                        <option value="dominica">Dominica</option>
                        <option value="dominican_republic">Dominican Republic</option>
                        <option value="ecuador">Ecuador</option>
                        <option value="egypt">Egypt</option>
                        <option value="el_salvador">El Salvador</option>
                        <option value="equatorial_guinea">Equatorial Guinea</option>
                        <option value="eritrea">Eritrea</option>
                        <option value="estonia">Estonia</option>
                        <option value="eswatini">Eswatini</option>
                        <option value="ethiopia">Ethiopia</option>
                        <option value="fiji">Fiji</option>
                        <option value="finland">Finland</option>
                        <option value="france">France</option>
                        <option value="gabon">Gabon</option>
                        <option value="gambia">Gambia</option>
                        <option value="georgia">Georgia</option>
                        <option value="germany">Germany</option>
                        <option value="ghana">Ghana</option>
                        <option value="greece">Greece</option>
                        <option value="grenada">Grenada</option>
                        <option value="guatemala">Guatemala</option>
                        <option value="guinea">Guinea</option>
                        <option value="guinea_bissau">Guinea-Bissau</option>
                        <option value="guyana">Guyana</option>
                        <option value="haiti">Haiti</option>
                        <option value="honduras">Honduras</option>
                        <option value="hungary">Hungary</option>
                        <option value="iceland">Iceland</option>
                        <option value="india">India</option>
                        <option value="indonesia">Indonesia</option>
                        <option value="iran">Iran</option>
                        <option value="iraq">Iraq</option>
                        <option value="ireland">Ireland</option>
                        <option value="israel">Israel</option>
                        <option value="italy">Italy</option>
                        <option value="jamaica">Jamaica</option>
                        <option value="japan">Japan</option>
                        <option value="jordan">Jordan</option>
                        <option value="kazakhstan">Kazakhstan</option>
                        <option value="kenya">Kenya</option>
                        <option value="kiribati">Kiribati</option>
                        <option value="korea_(north)">Korea (North)</option>
                        <option value="korea_(south)">Korea (South)</option>
                        <option value="kuwait">Kuwait</option>
                        <option value="kyrgyzstan">Kyrgyzstan</option>
                        <option value="laos">Laos</option>
                        <option value="latvia">Latvia</option>
                        <option value="lebanon">Lebanon</option>
                        <option value="lesotho">Lesotho</option>
                        <option value="liberia">Liberia</option>
                        <option value="libya">Libya</option>
                        <option value="liechtenstein">Liechtenstein</option>
                        <option value="lithuania">Lithuania</option>
                        <option value="luxembourg">Luxembourg</option>
                        <option value="madagascar">Madagascar</option>
                        <option value="malawi">Malawi</option>
                        <option value="malaysia">Malaysia</option>
                        <option value="maldives">Maldives</option>
                        <option value="mali">Mali</option>
                        <option value="malta">Malta</option>
                        <option value="marshall_islands">Marshall Islands</option>
                        <option value="mauritania">Mauritania</option>
                        <option value="mauritius">Mauritius</option>
                        <option value="micronesia">Micronesia</option>
                        <option value="moldova">Moldova</option>
                        <option value="monaco">Monaco</option>
                        <option value="mongolia">Mongolia</option>
                        <option value="montenegro">Montenegro</option>
                        <option value="morocco">Morocco</option>
                        <option value="mozambique">Mozambique</option>
                        <option value="myanmar_(burma)">Myanmar (Burma)</option>
                        <option value="namibia">Namibia</option>
                        <option value="nauru">Nauru</option>
                        <option value="nepal">Nepal</option>
                        <option value="netherlands">Netherlands</option>
                        <option value="new_zealand">New Zealand</option>
                        <option value="nicaragua">Nicaragua</option>
                        <option value="niger">Niger</option>
                        <option value="nigeria">Nigeria</option>
                        <option value="north_macedonia">North Macedonia</option>
                        <option value="norway">Norway</option>
                        <option value="oman">Oman</option>
                        <option value="pakistan">Pakistan</option>
                        <option value="palau">Palau</option>
                        <option value="panama">Panama</option>
                        <option value="papua_new_guinea">Papua New Guinea</option>
                        <option value="paraguay">Paraguay</option>
                        <option value="peru">Peru</option>
                        <option value="philippines">Philippines</option>
                        <option value="poland">Poland</option>
                        <option value="portugal">Portugal</option>
                        <option value="qatar">Qatar</option>
                        <option value="romania">Romania</option>
                        <option value="russia">Russia</option>
                        <option value="rwanda">Rwanda</option>
                        <option value="saint_kitts_and_nevis">Saint Kitts and Nevis</option>
                        <option value="saint_lucia">Saint Lucia</option>
                        <option value="saint_Vincent_and_the_grenadines">Saint Vincent and the Grenadines</option>
                        <option value="samoa">Samoa</option>
                        <option value="san_marino">San Marino</option>
                        <option value="sao_tome_and_principe">Sao Tome and Principe</option>
                        <option value="saudi_arabia">Saudi Arabia</option>
                        <option value="senegal">Senegal</option>
                        <option value="serbia">Serbia</option>
                        <option value="seychelles">Seychelles</option>
                        <option value="sierra Leone">Sierra Leone</option>
                        <option value="singapore">Singapore</option>
                        <option value="slovakia">Slovakia</option>
                        <option value="slovenia">Slovenia</option>
                        <option value="solomon_islands">Solomon Islands</option>
                    </select>
                    <div class="invalid-feedback country-error"></div>
                </div>
                <div class="col-md-8">
                    <label class="form-label" for="city">City</label>
                    <input type="text" class="form-control city" name="city" id="editCity" value="" placeholder="">
                    <div class="invalid-feedback city-error"></div>
                </div>
                       
                <div class="col-md-4 mb-1">
                    <label class="form-label">State/Province</label>
                    <select class="form-select form-select-sm js-choice border-0 state" name="state" id="editState">
                        <option value="" selected disabled>Select:</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DR">Dominican Republic</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="PC">Playa Confresi</option>
                        <option value="PP">Puerto Plata</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                     <div class="invalid-feedback state-error"></div>
                </div>

                <div class="col-md-12 text-end mt-md-4">
                    <button class="btn btn-info" type="submit" id="submitLocationBtn" name="submitLocationBtn">Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i></button>
                    <button type="button" data-bs-dismiss="modal" id="cancelBtn" class="btn btn btn-light cancelButton text-capitalize">Cancel</button>
                </div>
            </form>
      `);

    modalTitle.text(`Edit ${self.data('title')}`);
    submitButton.text(`Update ${self.data('title')} <i class="bi bi-chevron-double-right"></i>`);
    const country = self.data('country');
    const state = self.data('state');
    const city = self.data('city');
    updateChoice("editCountry", country);
    updateChoice("editState", state);
    $('#editCity').val(city);

});

let hotels = {
    init: function () {
        hotels.list();
        hotels.delete();
    },

    list: function () {
        $('#hotels').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'hotels';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($('#hotels').DataTable().page.info().page) + 1;
                    d.search = $('#hotels').DataTable().search();
                },
            },
            columnDefs: [
                {
                    targets: 0,
                    name: "id",
                    data: 'id',
                    orderable: true,
                    render: function (_data, _type, _full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: 1,
                    name: "name",
                    data: 'name',
                },
                {
                    targets: 2,
                    name: "country",
                    data: 'country',
                    render: function (data, type, row) {
                        return data.replace("_", " ").split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
                    }
                },
                {
                    targets: 3,
                    name: "city",
                    data: 'city',
                },
                {
                    targets: 4,
                    name: "state",
                    data: 'state',
                },
                {
                    targets: 5,
                    name: "actions",
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<a class="text-primary hotelDetails"
                                    href="#"
                                    data-id="${row.id}"
                                    data-title="Hotel"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hotelViewModal">
                                    <i class="bi bi-eye me-1"></i>
                                </a>
                                <a class="text-primary hotel"
                                    href="#"
                                    data-id="${row.id}"
                                    data-name="${row.name}"
                                    data-country="${row.country}"
                                    data-city="${row.city}"
                                    data-state="${row.state}"
                                    data-zip="${row.zip}"
                                    data-address="${row.address}"
                                    data-amenities="${row.amenities}"
                                    data-image="${row.hotel_images}"
                                    data-rating="${row.rating}"
                                    data-title="Hotel"
                                    data-bs-toggle="modal"
                                    data-bs-target="#customValueModal">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-hotel" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
                            `;
                    }
                }
            ]
        });
    },
    delete: function () {
        $(document).on("click", ".delete-hotel", function (e) {
            let id = $(this).attr("rel");
            let table = 'hotels';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'hotels', 'Hotel');
        });
    }
}
hotels.init();


let locations = {
    init: function () {
        locations.list();
        locations.delete();
    },
    list: function () {
        $('#locations').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'custom_locations';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($('#locations').DataTable().page.info().page) + 1;
                    d.search = $('#locations').DataTable().search();
                },
            },
            columnDefs: [
                {
                    targets: 0,
                    name: "id",
                    data: 'id',
                    orderable: true,
                    render: function (_data, _type, _full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: 1,
                    name: "country",
                    data: 'country',
                    render: function (data, type, row) {
                        return data.replace("_", " ").split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
                    }
                },
                {
                    targets: 2,
                    name: "city",
                    data: 'city',
                },
                {
                    targets: 3,
                    name: "state",
                    data: 'state',
                },
                {
                    targets: 4,
                    name: "actions",
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                                <a class="text-primary location"
                                    href="#"
                                    data-id="${row.id}"
                                    data-country="${row.country}"
                                    data-city="${row.city}"
                                    data-state="${row.state}"
                                    data-title="Location"
                                    data-bs-toggle="modal"
                                    data-bs-target="#customValueModal">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-location" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
                            `;
                    }
                }
            ]
        });
    },

    delete: function () {
        $(document).on("click", ".delete-location", function (e) {
            let id = $(this).attr("rel");
            let table = 'custom_locations';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'locations', 'Location');
        });
    }
}
locations.init();

let experiences = {
    init: function () {
        experiences.delete();
    },
    delete: function () {
        $(document).on("click", ".delete-experience", function (e) {
            let id = $(this).attr("data-id");
            let table = 'experiences';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'experiences', 'Experience');
        });
    }
}

experiences.init();

let experienceType = {
    init: function () {
        experienceType.delete();
    },
    delete: function () {
        $(document).on("click", ".delete-experience-type", function (e) {
            let id = $(this).attr("data-id");
            let table = 'experience_type';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'experience_type', 'Experience Type');
        });
    }
}
experienceType.init();

let textRates = {
    init: function () {
        textRates.delete();
    },
    delete: function () {
        $(document).on("click", ".delete-text-rate", function (e) {
            let id = $(this).attr("data-id");
            let table = 'night_rates';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'night_rates', 'Text Rate');
        });
    }
}
textRates.init();

let usdRates = {
    init: function () {
        usdRates.delete();
    },
    delete: function () {
        $(document).on("click", ".delete-usd-rate", function (e) {
            let id = $(this).attr("data-id");
            let table = 'night_rates';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'night_rates', 'Usd Rate');
        });
    }
}
usdRates.init();
// Experience form
$(document).on('submit', '#addEditExperienceForm', function (e) {
    e.preventDefault();

    const nameInput = $(this).find('.experience-name');
    const errorDiv = $(this).find('.experience-name-error');

    const experienceValid = validateInput(
        nameInput,
        errorDiv,
        'Please enter experience name'
    );

    if (experienceValid) {
        // If validation passes, proceed with AJAX submission
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/experience_submit.php';
        var showLoader = 'Processing....';

        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-custom-values.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    showButtonLoader(btn, btnName, false);
                    cancelBtn.prop("disabled", false);
                }
            },
            error: function (err) {
                handleError(err);
                // Restore button
                btn.prop('disabled', false);
                btn.html(btnName);
                cancelBtn.prop("disabled", false);
            },
        });
    }
});

// Experience Type form
$(document).on('submit', '#addEditExperienceTypeForm', function (e) {
    e.preventDefault();
    const nameInput = $(this).find('.experience-type-name');
    const errorDiv = $(this).find('.experience-type-name-error');

    const experienceTypeValid = validateInput(
        nameInput,
        errorDiv,
        'Please enter experience type name'
    );

    if (experienceTypeValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/experience_type_submit.php';
        var showLoader = 'Processing....';

        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-custom-values.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    showButtonLoader(btn, btnName, false);
                    cancelBtn.prop("disabled", false);
                }
            },
            error: function (err) {
                handleError(err);
                // Restore button
                btn.prop('disabled', false);
                btn.html(btnName);
                cancelBtn.prop("disabled", false);
            },
        });
    }
});

// Rate form
$(document).on('submit', '#rateForm', function (e) {
    e.preventDefault();
    const type = $(this).find('.type');
    const errorDiv = $(this).find('.type-error');
    const value = $(this).find('.value');
    const errorDivValue = $(this).find('.value-error');

    const typeValid = validateSelect(
        type,
        errorDiv,
        'Please select a type'
    );

    const valueValid = validateInput(
        value,
        errorDivValue,
        'Please enter a value'
    );

    if (typeValid && valueValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/rate_submit.php';
        var showLoader = 'Processing....';

        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-custom-values.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    showButtonLoader(btn, btnName, false);
                    cancelBtn.prop("disabled", false);
                }
            },
            error: function (err) {
                handleError(err);
                // Restore button
                btn.prop('disabled', false);
                btn.html(btnName);
                cancelBtn.prop("disabled", false);
            },
        });
    }
});

// Location form
$(document).on('submit', '#addEditLocationForm', function (e) {
    e.preventDefault();
    const country = $(this).find('.country');
    const errorDiv = $(this).find('.country-error');
    const state = $(this).find('.state');
    const errorDivState = $(this).find('.state-error');
    const city = $(this).find('.city');
    const errorDivCity = $(this).find('.city-error');

    const countryValid = validateSelect(
        country,
        errorDiv,
        'Please select a country'
    );

    const stateValid = validateSelect(
        state,
        errorDivState,
        'Please select a state'
    );

    const cityValid = validateInput(
        city,
        errorDivCity,
        'Please enter a city'
    );

    if (countryValid && stateValid && cityValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/location_submit.php';
        var showLoader = 'Processing....';

        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-custom-values.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    showButtonLoader(btn, btnName, false);
                    cancelBtn.prop("disabled", false);
                }
            },
            error: function (err) {
                handleError(err);
                // Restore button   
                btn.prop('disabled', false);
                btn.html(btnName);
                cancelBtn.prop("disabled", false);
            },
        });

    }
})

// Hotel form
$(document).on('submit', '#hotelForm', function (e) {
    e.preventDefault();

    const hotelName = $(this).find('.hotelName');
    const errorDiv = $(this).find('.hotelName-error');
    const hotelCountry = $(this).find('.hotelCountry');
    const errorDivHotelCountry = $(this).find('.hotelCountry-error');
    const hotelState = $(this).find('.hotelState');
    const errorDivHotelState = $(this).find('.hotelState-error');
    const hotelCity = $(this).find('.hotelCity');
    const errorDivHotelCity = $(this).find('.hotelCity-error');
    const address = $(this).find('.address');
    const errorDivAddress = $(this).find('.address-error');
    const zip = $(this).find('.zip');
    const errorDivZip = $(this).find('.zip-error');
    const amenities = $(this).find('.amenities');
    const errorDivAmenities = $(this).find('.amenities-error');
    const rating = $(this).find('.starRating');
    const errorDivRating = $(this).find('.starRating-error');

    const hotelNameValid = validateInput(hotelName, errorDiv, 'Please enter hotel name');
    const ishotelCountryValid = validateSelect(hotelCountry, errorDivHotelCountry, 'Please select a country');
    const ishotelStateValid = validateSelect(hotelState, errorDivHotelState, 'Please select a state');
    const ishotelCityValid = validateInput(hotelCity, errorDivHotelCity, 'Please enter a city');
    const isaddressValid = validateInput(address, errorDivAddress, 'Please enter an address');
    const iszipValid = validateInput(zip, errorDivZip, 'Please enter a zip');
    const isAmenitiesValid = validateSelect(amenities, errorDivAmenities, 'Please enter amenities');
    const isRatingValid = validateSelect(rating, errorDivRating, 'Please select a star rating');

    const imageInput = $(this).find('.hotelImage');
    const isHotelImageValid = (existingImages.length > 0 || selectedFiles.length > 0)
        ? true
        : validateFile(
            imageInput,
            $(this).find('.hotelImage-error'),
            'Please choose a hotel image'
        );

    if (
        !hotelNameValid || !ishotelCountryValid || !ishotelStateValid || !ishotelCityValid ||
        !isaddressValid || !iszipValid || !isAmenitiesValid || !isHotelImageValid || !isRatingValid
    ) {
        return; // Stop submission if any validation fails
    }

    // Find the submit button
    const $submitBtn = $(this).find('button[type="submit"]');
    // Disable the button
    $submitBtn.prop('disabled', true);
    // Show loader (Bootstrap spinner example)
    const originalBtnHtml = $submitBtn.html();
    $submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

    // All validations passed, now proceed with AJAX
    const formData = new FormData(this);

    formData.delete('search_terms');
    $.ajax({
        url: 'services/hotel_submit.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#7D5FFF',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'manage-custom-values.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Something went wrong.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#FF5E5E' // optional for error
                });
            }
        },
        error: function (error) {
            handleError(error);
        },
        complete: function () {
            // Re-enable button and restore text after AJAX finishes
            $submitBtn.prop('disabled', false);
            $submitBtn.html(originalBtnHtml);
        }
    });
});

