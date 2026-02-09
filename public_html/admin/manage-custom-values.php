<?php
$page = "custom-values";
$title = "Manage Custom Values";
include 'auth_check.php';
include 'includes/header.php';
include 'common.php';
?>

<?php
$experience_types = mysqli_query($con, "SELECT * FROM experience_type ORDER BY id DESC");
$experiences = mysqli_query($con, "SELECT * FROM experiences ORDER BY id DESC");
$rateType = mysqli_query($con, "SELECT * FROM night_rates WHERE type= 'Text'");
$rateValue = mysqli_query($con, "SELECT * FROM night_rates WHERE type= 'USD'");
?>

<!-- Top bar START -->

<div class="page-content-wrapper p-xxl-4">
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-asterisk pe-2"></i>Manage Experiences &amp; Experience Types</h4>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-3 h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Experience</div>
                        </div>
                    </div>
                    <form class="row g-3 mt-1" id="addEditExperienceForm">
                        <div class="col-md-12">
                            <label class="form-label" for="name">Experience name</label>
                            <input type="text" class="form-control experience-name" name="name" value="" placeholder="">
                            <div class="invalid-feedback experience-name-error"></div>
                        </div>

                        <div class="col-md-12 text-end mt-md-4">
                            <button class="btn btn-info" type="submit" id="submitExperienceBtn" name="submitExperienceBtn">Create Experience <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>

                    <div class="border-bottom my-3"></div>

                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Experience Type</div>
                        </div>
                    </div>
                    <form class="row g-3 mt-1" id="addEditExperienceTypeForm">
                        <div class="col-md-12">
                            <label class="form-label" for="name">Experience Type name</label>
                            <input type="text" class="form-control experience-type-name" name="name" value="" placeholder="">
                            <div class="invalid-feedback experience-type-name-error"></div>
                        </div>

                        <div class="col-md-12 text-end mt-md-4">
                            <button class="btn btn-info" type="submit" id="submitExperienceTypeBtn" name="submitExperienceTypeBtn">Create Experience Type <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-8 ">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Custom Values</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-6">
                            <table id="experiences" class="table table-sm table-hover fw-light display nowrap border" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Experiences</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    while ($experience = mysqli_fetch_array($experiences)) { ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $experience['name']; ?></td>
                                            <td><a class="text-primary experience"
                                                    href="#"
                                                    data-id="<?php echo $experience['id'] ?>"
                                                    data-name="<?php echo $experience['name'] ?>"
                                                    data-title="Experience"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#customValueModal">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                </a>
                                                <a class="text-primary delete-experience" href="#" data-id="<?php echo $experience['id'] ?>"><i class="bi bi-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive col-lg-6">
                            <table id="customValues" class="table table-sm table-hover fw-light display nowrap border" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Experience Types</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    while ($type = mysqli_fetch_array($experience_types)) { ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $type['name']; ?></td>
                                            <td><a class="text-primary experienceType"
                                                    href="#"
                                                    data-id="<?php echo $type['id'] ?>"
                                                    data-name="<?php echo $type['name'] ?>"
                                                    data-title="Experience Type"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#customValueModal">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                </a>
                                                <a class="text-primary delete-experience-type" href="#" data-id="<?php echo $type['id'] ?>"><i class="bi bi-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>

    <div class="border-bottom mb-5"></div>

    <!-- Hotels -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="">
                <h4 class="mb-0"><i class="bi bi-building pe-2"></i>Manage Hotels</h4>
                <p class="mt-2">Create static hotels entries for packages that do not use the hotel API</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Hotel</div>
                        </div>
                    </div>

                    <form class="row g-3 mt-1" id="hotelForm" enctype="multipart/form-data">
                        <div class="col-md-8">
                            <label class="form-label" for="hotelName">Hotel Name</label>
                            <input type="text" class="form-control hotelName" name="hotelName" id="hotelName" value="" placeholder="">
                            <div class="invalid-feedback hotelName-error"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="starRating" class="form-label">Star Rating</label>
                            <select class="form-select js-choice border-0 starRating" name="starRating" id="starRating">
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
                            <select class="form-select form-select-sm js-choice border-0 hotelCountry" name="hotelCountry" id="hotelCountry">
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
                            <input type="text" class="form-control address" name="address" id="address" value="" placeholder="">
                            <div class="invalid-feedback address-error"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="hotelCity">City</label>
                            <input type="text" class="form-control hotelCity" name="hotelCity" id="hotelCity" value="" placeholder="">
                            <div class="invalid-feedback hotelCity-error"></div>
                        </div>

                        <div class="col-md-4 mb-1">
                            <label class="form-label">State</label>
                            <select class="form-select form-select-sm js-choice border-0 hotelState" name="hotelState" id="hotelState">
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
                            <input type="text" class="form-control zip" name="zip" id="zip" value="" placeholder="">
                            <div class="invalid-feedback zip-error"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="amenities">Amenities</label>
                            <input type="text" class="form-select form-select-sm js-choice border-0 amenities" id="amenities" name="amenities[]" data-placeholder-val="Begin typing to create amenities list.">
                            <div class="invalid-feedback amenities-error"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="hotelImage">Hotel image(s)</label>
                            <input class="form-control hotelImage" type="file" name="hotelImage[]" id="hotelImage" multiple>
                            <div class="form-text">(Image types: .jpg, .jpeg, .png)</div>
                            <div id="hotelImagePreview" class="mt-2"></div>
                            <div class="invalid-feedback hotelImage-error"></div>
                        </div>
                        <div class="col-md-12 text-end mt-md-4">
                            <button class="btn btn-info" type="submit" name="hotel_submit">Create Hotel <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Custom Hotels</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <table id="hotels" class="table table-sm table-hover fw-light display nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Hotel Name</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-bottom mb-5"></div>

    <!-- Locations -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-geo-alt-fill pe-2"></i>Manage Locations</h4>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Location</div>
                        </div>
                    </div>

                    <form class="row g-3 mt-1" id="addEditLocationForm">
                        <div class="col-md-12 mb-1">
                            <label for="chooseCountry">Country</label>
                            <select class="form-select form-select-sm js-choice border-0 country" name="country" id="country">
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
                            <input type="text" class="form-control city" name="city" id="city" value="" placeholder="">
                            <div class="invalid-feedback city-error"></div>
                        </div>

                        <div class="col-md-4 mb-1">
                            <label class="form-label">State/Province</label>
                            <select class="form-select form-select-sm js-choice border-0 state" name="state" id="state">
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
                            <button class="btn btn-info" type="submit" id="submitLocationBtn" name="submitLocationBtn">Create Location <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Custom Locations</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-12">
                            <table id="locations" class="table table-sm table-hover fw-light display nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-bottom mb-5"></div>

    <!-- Additional Nights -->

    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-moon-stars pe-2"></i>Manage Additional Night Rates</h4>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-3 h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="h4">Create Rate</div>
                        </div>
                    </div>
                    <form class="row g-3 mt-1" id="rateForm">
                        <div class="col-md-4 mb-1">
                            <label class="form-label">Type</label>
                            <select class="form-select form-select-sm js-choice border-0 type" name="type" id="type">
                                <option value="" selected disabled>Choose:</option>
                                <option value="Text">Text</option>
                                <option value="USD">USD</option>
                            </select>
                            <div class="invalid-feedback type-error"></div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label" for="value">Value</label>
                            <input type="text" class="form-control value" name="value" value="" placeholder="" id="value">
                            <div class="invalid-feedback value-error"></div>
                        </div>

                        <div class="col-md-12 text-end mt-md-4">
                            <button class="btn btn-info" type="submit" id="submitRateBtn" name="submitRateBtn">Create Rate <i class="bi bi-chevron-double-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-8 ">
            <div class="card shadow rounded-3 h-100">
                <div class="card-header border-bottom">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div>
                            <div class="h4">Custom Rates</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive col-lg-6">
                            <table id="customValues" class="table table-sm table-hover fw-light display nowrap border" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Text Rates</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    while ($row = mysqli_fetch_assoc($rateType)) { ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $row['value'] ?></td>
                                            <td><a class="text-primary rate"
                                                    href="#"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-type="<?php echo $row['type'] ?>"
                                                    data-name="<?php echo $row['value'] ?>"
                                                    data-title="Rate"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#customValueModal">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                </a>
                                                <a class="text-primary delete-text-rate" href="#" data-id="<?php echo $row['id'] ?>"><i class="bi bi-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive col-lg-6">
                            <table id="customValues" class="table table-sm table-hover fw-light display nowrap border" width="100%">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>USD Rates</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    while ($row = mysqli_fetch_assoc($rateValue)) { ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo '$' .$row['value']; ?></td>
                                            <td><a class="text-primary rate"
                                                    href="#"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-type="<?php echo $row['type'] ?>"
                                                    data-name="<?php echo $row['value'] ?>"
                                                    data-title="Rate"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#customValueModal">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                </a>
                                                <a class="text-primary delete-usd-rate" href="#" data-id="<?php echo $row['id'] ?>"><i class="bi bi-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</div>

<!-----Custom Value Model ----------->
<div class="modal modal-lg fade" tabindex="-1" id="customValueModal" aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryFormlabel">Edit Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-3">
            </div>
        </div>
    </div>
</div>

<!-----Hotel View Model ----------->
<div class="modal modal-lg fade" tabindex="-1" id="hotelViewModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <!-- Title -->
            <div class="modal-header">
                <h5 class="modal-title" id="">Hotel Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-3">
            </div>
        </div>
    </div>
</div>
<!-- **************** MAIN CONTENT END **************** -->
<?php include('includes/footer.php'); ?>
</body>
<script src="../assets/js/admin/manage-custom-value.js"></script>