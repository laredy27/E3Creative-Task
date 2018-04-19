w<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="wrapper mt-4">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <p class="card-title"> Fill in your last birthday </p>
                            </div>
                    <div class="card-body">
                        <form id="birthday-form" class="form-inline justify-content-between">
                              <div class="form-group">
                                  <label class="sr-only" for="day">Day of birth</label>
                                  <input type="number" max="31" min="1" id="day" name="day" class="form-control" placeholder="Day" required /> 
                              </div><!--DAY-->

                              <div class="form-group">
                                    <label class="sr-only" for="month"></label>
                                    <select id="month" name="month" data-select="months" class="form-control" required>
                                        <option selected disabled value="">Select a month</option>
                                        <!--Populate this with jQuery-->
                                    </select>
                              </div>

                              <div class="form-group">
                                    <label class="sr-only" for="year"></label>
                                    <select id="month" name="year" data-select="year" class="form-control" required>
                                        <option selected disabled value="">Select a year</option>
                                        <!--Populate this with jQuery-->
                                    </select>
                              </div>
                              <input type="hidden" name="action" value="add_birthday" />
                              <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                        <div id="form-info" class="alert" role="alert"></div>
                    </div>
                </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header border-bottom-0 bg-white">
                                <h4 class="card-title">Birthday List</h4>
                            </div>
                        <div class="card-body">
                            <table id="birthdayTable" class="table table-hover border-top-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Birthday</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--This would be populated with ajax-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header border-bottom-0 bg-white">
                        
                        <div class="card-title">
                            <label for>Base Currency: </label>
                            <select id="base_currency" data-select="currency">
                            </select>
                        </div>
                        <h4 class="card-title">Exchange rates</h4>
                    </div>
                    <div class="card-body">
                        <div id="rates-info" class="alert alert-info" role="alert">Select an entry from the Birthday list</div>
                        <table id="ratesTable" class="table">
                            <tbody></tbody>
                        </table>
                        <div id="rates-error" class="alert alert-danger" role="alert"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

