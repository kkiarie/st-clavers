<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<?php 

use App\Models\Setting;

$Setting = Setting::find(1);

?>

<!DOCTYPE html>

@if (\Request::is('rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en" >
@endif

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>{{$Setting->title}}</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets') }}/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   @livewireStyles
</head>

<body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }} ">
  @auth
    @yield('auth')
  @endauth
  @guest
    @yield('guest')
  @endguest

  @if(session()->has('success'))
    <div x-data="{ show: true}"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0">{{ session('success')}}</p>
    </div>
  @endif
    <!--   Core JS Files   -->
  <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/fullcalendar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
  @stack('rtl')
  @stack('dashboard')
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
 <script src="{{ asset('assets') }}/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
<style type="text/css">
  .icon-shape i{

    color:#000 !important;
    font-size:15px;
  }
  .theme-selector{
    display:none !important;

  }
</style>

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            

 

$("#input-from_date").datepicker({
    format: 'yyyy-mm-dd',

});


$("#input-to_date").datepicker({
    format: 'yyyy-mm-dd',

});




$("#input-date_of_intimation").datepicker({
    format: 'yyyy-mm-dd',

});


$("#input-date_of_loss").datepicker({
    format: 'yyyy-mm-dd',

});



$("#input-gl_date").datepicker({
    format: 'yyyy-mm-dd',

});



$("#input-close_date").datepicker({
    format: 'yyyy-mm-dd',

});




        </script>


  <script type="text/javascript" src="{{ asset('argon') }}/vendor/timepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#timepicker1').timepicker({

    timeFormat: 'H:mm:ss',
    interval: 20,
    minTime: '6',
    maxTime: '20:00pm',
    startTime: '6:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#timepicker2').timepicker({

    timeFormat: 'H:mm:ss',
    interval: 20,
    minTime: '6',
    maxTime: '20:00pm',
    startTime: '6:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
    });
});
</script>



<style type="text/css">
  /**
 * selectize.default.css (v0.12.6) - Default Theme
 * Copyright (c) 2013–2015 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */
.selectize-control.plugin-drag_drop.multi > .selectize-input > div.ui-sortable-placeholder {
  visibility: visible !important;
  background: #f2f2f2 !important;
  background: rgba(0, 0, 0, 0.06) !important;
  border: 0 none !important;
  -webkit-box-shadow: inset 0 0 12px 4px #fff;
  box-shadow: inset 0 0 12px 4px #fff;
}
.selectize-control.plugin-drag_drop .ui-sortable-placeholder::after {
  content: '!';
  visibility: hidden;
}
.selectize-control.plugin-drag_drop .ui-sortable-helper {
  -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
.selectize-dropdown-header {
  position: relative;
  padding: 5px 8px;
  border-bottom: 1px solid #d0d0d0;
  background: #f8f8f8;
  -webkit-border-radius: 3px 3px 0 0;
  -moz-border-radius: 3px 3px 0 0;
  border-radius: 3px 3px 0 0;
}
.selectize-dropdown-header-close {
  position: absolute;
  right: 8px;
  top: 50%;
  color: #303030;
  opacity: 0.4;
  margin-top: -12px;
  line-height: 20px;
  font-size: 20px !important;
}
.selectize-dropdown-header-close:hover {
  color: #000000;
}
.selectize-dropdown.plugin-optgroup_columns .optgroup {
  border-right: 1px solid #f2f2f2;
  border-top: 0 none;
  float: left;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.selectize-dropdown.plugin-optgroup_columns .optgroup:last-child {
  border-right: 0 none;
}
.selectize-dropdown.plugin-optgroup_columns .optgroup:before {
  display: none;
}
.selectize-dropdown.plugin-optgroup_columns .optgroup-header {
  border-top: 0 none;
}
.selectize-control.plugin-remove_button [data-value] {
  position: relative;
  padding-right: 24px !important;
}
.selectize-control.plugin-remove_button [data-value] .remove {
  z-index: 1;
  /* fixes ie bug (see #392) */
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 17px;
  text-align: center;
  font-weight: bold;
  font-size: 12px;
  color: inherit;
  text-decoration: none;
  vertical-align: middle;
  display: inline-block;
  padding: 2px 0 0 0;
  border-left: 1px solid #0073bb;
  -webkit-border-radius: 0 2px 2px 0;
  -moz-border-radius: 0 2px 2px 0;
  border-radius: 0 2px 2px 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.selectize-control.plugin-remove_button [data-value] .remove:hover {
  background: rgba(0, 0, 0, 0.05);
}
.selectize-control.plugin-remove_button [data-value].active .remove {
  border-left-color: #00578d;
}
.selectize-control.plugin-remove_button .disabled [data-value] .remove:hover {
  background: none;
}
.selectize-control.plugin-remove_button .disabled [data-value] .remove {
  border-left-color: #aaaaaa;
}
.selectize-control.plugin-remove_button .remove-single {
  position: absolute;
  right: 0;
  top: 0;
  font-size: 23px;
}
.selectize-control {
  position: relative;
}
.selectize-dropdown,
.selectize-input,
.selectize-input input {
  color: #303030;
  font-family: inherit;
  font-size: 13px;
  line-height: 18px;
  -webkit-font-smoothing: inherit;
}
.selectize-input,
.selectize-control.single .selectize-input.input-active {
  background: #fff;
  cursor: text;
  display: inline-block;
}
.selectize-input {
  border: 1px solid #d0d0d0;
  padding: 8px 8px;
  display: inline-block;
  width: 100%;
  overflow: hidden;
  position: relative;
  z-index: 1;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.selectize-control.multi .selectize-input.has-items {
  padding: 5px 8px 2px;
}
.selectize-input.full {
  background-color: #fff;
}
.selectize-input.disabled,
.selectize-input.disabled * {
  cursor: default !important;
}
.selectize-input.focus {
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15);
}
.selectize-input.dropdown-active {
  -webkit-border-radius: 3px 3px 0 0;
  -moz-border-radius: 3px 3px 0 0;
  border-radius: 3px 3px 0 0;
}
.selectize-input > * {
  vertical-align: baseline;
  display: -moz-inline-stack;
  display: inline-block;
  zoom: 1;
  *display: inline;
}
.selectize-control.multi .selectize-input > div {
  cursor: pointer;
  margin: 0 3px 3px 0;
  padding: 2px 6px;
  background: #1da7ee;
  color: #fff;
  border: 1px solid #0073bb;
}
.selectize-control.multi .selectize-input > div.active {
  background: #92c836;
  color: #fff;
  border: 1px solid #00578d;
}
.selectize-control.multi .selectize-input.disabled > div,
.selectize-control.multi .selectize-input.disabled > div.active {
  color: #ffffff;
  background: #d2d2d2;
  border: 1px solid #aaaaaa;
}
.selectize-input > input {
  display: inline-block !important;
  padding: 0 !important;
  min-height: 0 !important;
  max-height: none !important;
  max-width: 100% !important;
  margin: 0 1px !important;
  text-indent: 0 !important;
  border: 0 none !important;
  background: none !important;
  line-height: inherit !important;
  -webkit-user-select: auto !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
}
.selectize-input > input::-ms-clear {
  display: none;
}
.selectize-input > input:focus {
  outline: none !important;
}
.selectize-input::after {
  content: ' ';
  display: block;
  clear: left;
}
.selectize-input.dropdown-active::before {
  content: ' ';
  display: block;
  position: absolute;
  background: #f0f0f0;
  height: 1px;
  bottom: 0;
  left: 0;
  right: 0;
}
.selectize-dropdown {
  position: absolute;
  z-index: 10;
  border: 1px solid #d0d0d0;
  background: #fff;
  margin: -1px 0 0 0;
  border-top: 0 none;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  -webkit-border-radius: 0 0 3px 3px;
  -moz-border-radius: 0 0 3px 3px;
  border-radius: 0 0 3px 3px;
}
.selectize-dropdown [data-selectable] {
  cursor: pointer;
  overflow: hidden;
}
.selectize-dropdown [data-selectable] .highlight {
  background: rgba(125, 168, 208, 0.2);
  -webkit-border-radius: 1px;
  -moz-border-radius: 1px;
  border-radius: 1px;
}
.selectize-dropdown .option,
.selectize-dropdown .optgroup-header {
  padding: 5px 8px;
}
.selectize-dropdown .option,
.selectize-dropdown [data-disabled],
.selectize-dropdown [data-disabled] [data-selectable].option {
  cursor: inherit;
  opacity: 0.5;
}
.selectize-dropdown [data-selectable].option {
  opacity: 1;
}
.selectize-dropdown .optgroup:first-child .optgroup-header {
  border-top: 0 none;
}
.selectize-dropdown .optgroup-header {
  color: #303030;
  background: #fff;
  cursor: default;
}
.selectize-dropdown .active {
  background-color: #f5fafd;
  color: #495c68;
}
.selectize-dropdown .active.create {
  color: #495c68;
}
.selectize-dropdown .create {
  color: rgba(48, 48, 48, 0.5);
}
.selectize-dropdown-content {
  overflow-y: auto;
  overflow-x: hidden;
  max-height: 200px;
  -webkit-overflow-scrolling: touch;
}
.selectize-control.single .selectize-input,
.selectize-control.single .selectize-input input {
  cursor: pointer;
}
.selectize-control.single .selectize-input.input-active,
.selectize-control.single .selectize-input.input-active input {
  cursor: text;
}
.selectize-control.single .selectize-input:after {
  content: ' ';
  display: block;
  position: absolute;
  top: 50%;
  right: 15px;
  margin-top: -3px;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 5px 5px 0 5px;
  border-color: #808080 transparent transparent transparent;
}
.selectize-control.single .selectize-input.dropdown-active:after {
  margin-top: -4px;
  border-width: 0 5px 5px 5px;
  border-color: transparent transparent #808080 transparent;
}
.selectize-control.rtl.single .selectize-input:after {
  left: 15px;
  right: auto;
}
.selectize-control.rtl .selectize-input > input {
  margin: 0 4px 0 -2px !important;
}
.selectize-control .selectize-input.disabled {
  opacity: 0.5;
  background-color: #fafafa;
}
.selectize-control.multi .selectize-input.has-items {
  padding-left: 5px;
  padding-right: 5px;
}
.selectize-control.multi .selectize-input.disabled [data-value] {
  color: #999;
  text-shadow: none;
  background: none;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.selectize-control.multi .selectize-input.disabled [data-value],
.selectize-control.multi .selectize-input.disabled [data-value] .remove {
  border-color: #e6e6e6;
}
.selectize-control.multi .selectize-input.disabled [data-value] .remove {
  background: none;
}
.selectize-control.multi .selectize-input [data-value] {
  text-shadow: 0 1px 0 rgba(0, 51, 83, 0.3);
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background-color: #1b9dec;
  background-image: -moz-linear-gradient(top, #1da7ee, #178ee9);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#1da7ee), to(#178ee9));
  background-image: -webkit-linear-gradient(top, #1da7ee, #178ee9);
  background-image: -o-linear-gradient(top, #1da7ee, #178ee9);
  background-image: linear-gradient(to bottom, #1da7ee, #178ee9);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff1da7ee', endColorstr='#ff178ee9', GradientType=0);
  -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.2),inset 0 1px rgba(255,255,255,0.03);
  box-shadow: 0 1px 0 rgba(0,0,0,0.2),inset 0 1px rgba(255,255,255,0.03);
}
.selectize-control.multi .selectize-input [data-value].active {
  background-color: #0085d4;
  background-image: -moz-linear-gradient(top, #008fd8, #0075cf);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#008fd8), to(#0075cf));
  background-image: -webkit-linear-gradient(top, #008fd8, #0075cf);
  background-image: -o-linear-gradient(top, #008fd8, #0075cf);
  background-image: linear-gradient(to bottom, #008fd8, #0075cf);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff008fd8', endColorstr='#ff0075cf', GradientType=0);
}
.selectize-control.single .selectize-input {
  -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.8);
  box-shadow: 0 1px 0 rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.8);
  background-color: #f9f9f9;
  background-image: -moz-linear-gradient(top, #fefefe, #f2f2f2);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fefefe), to(#f2f2f2));
  background-image: -webkit-linear-gradient(top, #fefefe, #f2f2f2);
  background-image: -o-linear-gradient(top, #fefefe, #f2f2f2);
  background-image: linear-gradient(to bottom, #fefefe, #f2f2f2);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffefefe', endColorstr='#fff2f2f2', GradientType=0);
}
.selectize-control.single .selectize-input,
.selectize-dropdown.single {
  border-color: #b8b8b8;
}
.selectize-dropdown .optgroup-header {
  padding-top: 7px;
  font-weight: bold;
  font-size: 0.85em;
}
.selectize-dropdown .optgroup {
  border-top: 1px solid #f0f0f0;
}
.selectize-dropdown .optgroup:first-child {
  border-top: 0 none;
}
pre{
  display:none;
}
em{
  color: red;
}
label{
  font-weight: bolder;
}



.datepicker
{
    border-radius: .375rem;

    direction: ltr;
}
.datepicker-inline
{
    width: 220px;
}
.datepicker-rtl
{
    direction: rtl;
}
.datepicker-rtl.dropdown-menu
{
    left: auto;
}
.datepicker-rtl table tr td span
{
    float: right;
}
.datepicker-dropdown
{
    top: 0;
    left: 0;

    padding: 20px 22px;

    box-shadow: 0 50px 100px rgba(50, 50, 93, .1), 0 15px 35px rgba(50, 50, 93, .15), 0 5px 15px rgba(0, 0, 0, .1);
}
.datepicker-dropdown.datepicker-orient-left:before
{
    left: 6px;
}
.datepicker-dropdown.datepicker-orient-left:after
{
    left: 7px;
}
.datepicker-dropdown.datepicker-orient-right:before
{
    right: 6px;
}
.datepicker-dropdown.datepicker-orient-right:after
{
    right: 7px;
}
.datepicker-dropdown.datepicker-orient-bottom:before
{
    top: -7px;
}
.datepicker-dropdown.datepicker-orient-bottom:after
{
    top: -6px;
}
.datepicker-dropdown.datepicker-orient-top:before
{
    bottom: -7px;

    border-top: 7px solid white; 
    border-bottom: 0;
}
.datepicker-dropdown.datepicker-orient-top:after
{
    bottom: -6px;

    border-top: 6px solid #fff; 
    border-bottom: 0;
}
.datepicker table
{
    margin: 0;

    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none; 

    -webkit-touch-callout: none;
}
.datepicker table tr td
{
    border-radius: 50%;
}
.datepicker table tr th
{
    font-weight: 500; 

    border-radius: .375rem;
}
.datepicker table tr td,
.datepicker table tr th
{
    font-size: .875rem; 

    width: 36px;
    height: 36px;

    transition: all .15s ease;
    text-align: center;

    border: none;
}
.table-striped .datepicker table tr td,
.table-striped .datepicker table tr th
{
    background-color: transparent;
}
.datepicker table tr td.old,
.datepicker table tr td.new
{
    color: #adb5bd;
}
.datepicker table tr td.day:hover,
.datepicker table tr td.focused
{
    cursor: pointer; 

    background: white;
}
.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover
{
    cursor: default; 

    color: #dee2e6;
    background: none;
}
.datepicker table tr td.highlighted
{
    border-radius: 0;
}
.datepicker table tr td.highlighted.focused
{
    background: #5e72e4;
}
.datepicker table tr td.highlighted.disabled,
.datepicker table tr td.highlighted.disabled:active
{
    color: #ced4da; 
    background: #5e72e4;
}
.datepicker table tr td.today
{
    background: white;
}
.datepicker table tr td.today.focused
{
    background: white;
}
.datepicker table tr td.today.disabled,
.datepicker table tr td.today.disabled:active
{
    color: #8898aa; 
    background: white;
}
.datepicker table tr td.range
{
    color: #fff;
    border-radius: 0; 
    background: #5e72e4;
}
.datepicker table tr td.range.focused
{
    background: #3b53de;
}
.datepicker table tr td.range.disabled,
.datepicker table tr td.range.disabled:active,
.datepicker table tr td.range.day.disabled:hover
{
    color: #8a98eb; 
    background: #324cdd;
}
.datepicker table tr td.range.highlighted.focused
{
    background: #cbd3da;
}
.datepicker table tr td.range.highlighted.disabled,
.datepicker table tr td.range.highlighted.disabled:active
{
    color: #dee2e6; 
    background: #e9ecef;
}
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today.disabled:active
{
    color: #fff; 
    background: #5e72e4;
}
.datepicker table tr td.day.range-start
{
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.datepicker table tr td.day.range-end
{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.datepicker table tr td.day.range-start.range-end
{
    border-radius: 50%;
}
.datepicker table tr td.selected,
.datepicker table tr td.selected.highlighted,
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected.highlighted:hover,
.datepicker table tr td.day.range:hover
{
    color: #fff; 
    background: #5e72e4;
}
.datepicker table tr td.active,
.datepicker table tr td.active.highlighted,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.highlighted:hover
{
    color: #fff;
    background: #5e72e4;
    box-shadow: none;
}
.datepicker table tr td span
{
    line-height: 54px;

    display: block;
    float: left;

    width: 23%;
    height: 54px;
    margin: 1%;

    cursor: pointer;

    border-radius: 4px;
}
.datepicker table tr td span:hover,
.datepicker table tr td span.focused
{
    background: #e9ecef;
}
.datepicker table tr td span.disabled,
.datepicker table tr td span.disabled:hover
{
    cursor: default; 

    color: #dee2e6;
    background: none;
}
.datepicker table tr td span.active,
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active.disabled:hover
{
    text-shadow: 0 -1px 0 rgba(0, 0, 0, .25);
}
.datepicker table tr td span.old,
.datepicker table tr td span.new
{
    color: #8898aa;
}
.datepicker .datepicker-switch
{
    width: 145px;
}
.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next,
.datepicker tfoot tr th
{
    cursor: pointer;
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover
{
    background: #e9ecef;
}
.datepicker .prev.disabled,
.datepicker .next.disabled
{
    visibility: hidden;
}
.datepicker .cw
{
    font-size: 10px;

    width: 12px;
    padding: 0 2px 0 5px;

    vertical-align: middle;
}
</style>

 <script src="{{ asset('js') }}/index.js"></script>
 <script src="{{ asset('js') }}/selectize.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function(){
        $('#select-item').selectize({
          maxItems: 1
        });
    });
</script>
  <script type="text/javascript">
  $(document).ready(function(){
        $('.select-item').selectize({
          maxItems: 1
        });
    });
</script>

  <script type="text/javascript">
  $(document).ready(function(){
        $('#select-item-1').selectize({
          maxItems: 1
        });
    });
</script>

  <script type="text/javascript">
  $(document).ready(function(){
        $('.mydatalist').selectize({
          maxItems: 1
        });
    });
</script>


@livewireScripts
</body>

</html>
