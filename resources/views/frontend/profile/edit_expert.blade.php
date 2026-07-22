@extends('frontend.layouts.intro.appnew',['title'=>' پروفایل مشاور'])

@section('head')

<link href="{{asset('admin2/plugins/fileuploads/css/dropify.min.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">

<script src="{{asset('/mainpage/js/cropper.js')}}"></script>



<style>
    .gradiantover1 {
        border-radius: 30px;
        width: 100%;
        height: 159px;
        position: absolute;
        height: 159px;
        background: linear-gradient(0deg, rgba(255, 255, 255, .1) 0, black 550%);
    }

    .gradiantover {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        width: 159px;
        height: 159px;
        position: absolute;
        height: 159px;
        background: linear-gradient(0deg, rgba(255, 255, 255, .1) 0, black 550%);
    }

    .graddelete {
        position: absolute;
        right: 43%;
        top: 40.81%;
        font-family: 'Font Awesome 6 Pro';
        font-style: normal;
        font-weight: 100;
        font-size: 36px;
        line-height: 36px;
        text-align: right;
        color: #FF7373;
    }

    .card-img {
        position: relative;
        border-radius: 30px;
        width: 100%;
        height: 165px;
        background: white
    }

    .card-img-box {
        border-radius: 50%;
        width: 159px;
        height: 164px;
        background: white;
    }

    .borderblack {
        border: 3px dotted black
    }

    .borderred {
        border: 3px dotted red
    }

    .pen {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgb(0 0 0 / 12%);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .pen:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 4px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    #district1::-webkit-scrollbar {
        width: 12px;
        /* width of the entire scrollbar */
    }

    #district1::-webkit-scrollbar-track {
        background: #F8F8F8;
        /* color of the tracking area */
    }

    #district1::-webkit-scrollbar-thumb {
        background-color: #C4C4C4;
        /* color of the scroll thumb */
        border-radius: 20px;
        /* roundness of the scroll thumb */
        border: 3px solid #C4C4C4;
        /* creates padding around scroll thumb */
    }

    .dcirlecontent {
        height: 100%;
        padding-top: 14px;
        font-size: 20px
    }

    .dcirlecontent1 {
        height: 100%;
        font-size: 16px;
        padding-top: 10px
    }

    .dcirlecontent2 {
        height: 100%;
        font-size: 16px;
        padding-top: 10px
    }

    .color_FF7373 {
        color: #FF7373
    }

    .color_5C5C5C {
        color: #5C5C5C
    }

    .color_025EC6 {
        color: #025EC6
    }

    .actived i {
        color: #025EC6
    }

    .actived {
        border: 0.961261px solid #025EC6
    }

    .deactive {
        border: 0.961261px solid #5C5C5C
    }

    .deactive i {
        color: #E7E7E7
    }

    .deactive span {
        color: #5C5C5C
    }

    .actived span {
        color: #025EC6
    }

    .color_A3A3A3 {
        color: #A3A3A3
    }

    .color_E7E7E7 {
        color: #E7E7E7
    }

    .pml_5 {
        padding-left: 5px
    }

    .dcircle {
        margin: 10px;
        background: white;
        box-sizing: border-box;
        border-radius: 23.0703px;
        width: 173px;
        height: 59px;
        ;
        float: right;
        background: #FFFFFF;
    }

    .dcircle1 {
        margin: 3px;
        background: white;
        box-sizing: border-box;
        border-radius: 23.0703px;
        float: right;
        background: #FFFFFF;
    }

    .dcircle2 {
        margin: 3px;
        background: white;
        box-sizing: border-box;
        border-radius: 23.0703px;
        float: right;
        background: #FFFFFF;
    }

    .border_025EC6 {
        border: 0.961261px solid #025EC6
    }

    .border_A3A3A3 {
        border: 0.961261px solid #A3A3A3
    }

    .select2-selection__choice__remove {
        color: red;
        font-size: 25px;
        padding-left: 10px;
        padding-top: 5px
    }

    .select2-selection__plus {
        margin: 3px;
        background: white;
        border-radius: 23px;
        border: 1px solid gray;
        float: right;
        font-size: 32px;
        padding-right: 20px;
        ;
        padding-left: 20px;
        color: gray;
        width: 66px;
        height: 48px
    }

    .select2-selection__choice {
        background: white;
        border-radius: 10px;
        border: 1px solid blue;
        float: right;
        margin-left: 5px;
        margin-right: auto;
        padding-right: 10px;
        padding-left: 10px;
        ;
        padding-top: 5px;
        padding-bottom: 5px;
        margin-bottom: 2px;
        margin-top: 2px;
    }

    .pr-1 {
        padding-right: 20px
    }

    :root {
        /* Primary */
        --color-primary-panel: #8C81D7;
        --light-orange-panel: #FA896B;
        --dark-orange-panel: #FF7373;
        --dark-text-panel: #5C5C5C;
        --light-text-panel: #A3A3A3;
        --background-panle: #F9F9F9;
        --background-sidebar: #F4F6FC;
    }

    body {
        background-color: var(--background-panle);
    }

    .row {
        --bs-gutter-x: .75rem;
    }

    .border-panel {
        border: 1px solid #E7E7E7;
        border-radius: 25px;
    }

    .sidebar-item {
        margin-top: 15px;
        padding: 0 12px;
        border-top: 1px solid #E7E7E7;
    }

    .sidebar-link {
        color: var(--dark-text-panel);
        fill: var(--dark-text-panel);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-list {
        display: flex;
        justify-content: space-between;
        padding: 12px 5px;
        color: #777;
    }

    .icon-sidebar {
        width: 25px;
        height: 27px;
        fill: var(--light-text-panel);
    }

    .sidebar-badge-item {
        position: relative;
    }

    .sidebar-badge-item::before {
        position: absolute;
        top: -2px;
        right: 15px;
        content: "";
        background-color: #44ABD7;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .sidebar-badge-chat {
        position: relative;
    }

    .sidebar-badge-chat::before {
        position: absolute;
        top: -2px;
        right: 15px;
        content: "";
        background-color: var(--dark-orange-panel);
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .sidebar-list.active .sidebar-link {
        font-weight: 700;
        color: var(--color-primary-panel) !important;
    }

    .sidebar-list.active .sidebar-link svg {
        fill: var(--color-primary-panel);
    }

    .sidebar-link:hover {
        color: var(--light-orange-panel) !important;
        fill: var(--light-orange-panel);
    }

    .sidebar-profile-img {
        position: relative;
        margin: 63px auto 17px;
    }

    .sidebar-profile-img {
        position: relative;
    }

    .profile-img {
        width: 122px;
        height: 122px;
        overflow: hidden;
        border-radius: 100px;
    }

    .sidebar-profile-edit {
        position: absolute;
        bottom: 0;
        left: 0;

    }

    .text-panel {
        color: var(--dark-text-panel);
    }

    .text-panel-primary {
        color: var(--color-primary-panel)
    }

    .text-light {
        fill: var(--light-text-panel);
        color: var(--light-text-panel);
        width: 27px;
        height: 27px;
    }

    .text-orange {
        color: var(--light-orange-panel);
    }

    .text-muted {
        color: var(--light-text-panel);
    }

    .sidebar-profile-edit {
        position: absolute;
        bottom: -3px;
        left: 65px;
        background: #fff;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        color: var(--color-primary-panel);
    }

    .sidebar-profile-name {
        font-size: 18px;
        color: var(--dark-text-panel);
    }

    .sidebar-profile-agent {
        font-size: 14px;
        color: var(--light-text-panel);
    }

    .sidebar-admin-box {
        background-color: var(--background-sidebar);
        min-height: 800px;
    }

    .panel-badge {
        color: #fff;
        /* background-color: var(--dark-orange-panel); */
        width: 23px;
        height: 23px;
        padding-top: 3px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        color: var(--dark-text-panel);
        font-weight: 300;
    }

    .btn-admin {
        color: #fff;
        background-color: var(--color-primary-panel);
        border-radius: 50px;
        border: 1px solid #E7E7E7;
        font-size: 18px !important;
        font-weight: 400;
    }

    .btn-admin-px {
        font-size: 15px !important;
        padding: 6px 40px;
    }

    .btn-admin:disabled {
        color: #fff !important;
        background-color: #9FA5AA !important;
        border-color: #9FA5AA !important;
    }

    .btn-admin:hover {
        color: #fff;
        background-color: var(--color-primary-panel);
        border: 1px solid #E7E7E7;
    }

    .btn-admin-white {
        background-color: #fff;
        color: var(--dark-text-panel);
        border-radius: 50px;
        border: 1px solid #E7E7E7;
        font-size: 18px !important;
        font-weight: 400;
    }

    .btn-admin-white:hover {
        background-color: #fff;
        color: var(--dark-text-panel);
        border: 1px solid #E7E7E7;
    }

    .btn-buyer {
        background-color: #fff;
        color: var(--dark-text-panel);
        border-radius: 50px;
        border: 1px solid #E7E7E7;
        font-size: 18px !important;
        font-weight: 400;
        width: 100%;
        text-align: center;
        display: flex;
        justify-content: center;
        gap: 12px;
        align-items: center;
        font-weight: 300;
    }

    .title-page {
        color: var(--dark-text-panel);
        font-size: 24px;
    }

    .panel-admin-box {
        position: relative;
        background: #F8F8F8;
        border: 1px solid #E7E7E7;
        border-radius: 25px;
        min-height: 150px;
        padding: 17px;
    }

    .admin-box2 {
        min-height: 360px;
    }

    .agent-rank-me {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background-color: var(--background-sidebar);
        display: flex;
        justify-content: space-between;
        border-radius: 0 0 10px 10px;
        align-items: center;
        border-top: 1px solid #E7E7E7;
    }

    .panel-admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-header-gary {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 400 !important;
        padding: 0 0 6px 15px;
        border-bottom: 3px solid #E7E7E7;
        font-size: 18px;
        font-weight: 300;
        color: var(--light-text-panel);
        cursor: pointer;
    }

    .panel-active {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 0 6px 15px;
        border-bottom: 3px solid var(--color-primary-panel);
        font-size: 18px;
        color: var(--dark-text-panel);
        font-weight: 400 !important;
    }

    .panel-header-right {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 0 6px 15px;
        font-size: 18px;
        color: var(--dark-text-panel);
        fill: var(--light-text-panel);
        font-weight: 400 !important;
    }



    .panel-header-left {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--color-primary-panel);
    }

    .agent-better-img-box {
        position: relative;
        margin: 10px auto;
        display: flex;
        justify-content: center;
    }

    .agent-better-rank {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50%;
        color: var(--dark-orange-panel);
        display: flex;
        justify-content: center;
        align-items: center;
        transform: translate(-50%, 45%);
    }

    .agent-better-name {
        font-size: 13px;
        color: var(--dark-text-panel);
        margin-bottom: 0;
    }

    .agent-better-score {
        color: var(--light-orange-panel);
        font-size: 12px;
        font-weight: 500;
    }

    .agent-better-top {
        display: flex;
        justify-content: center;
        /* align-items: flex-end; */
    }

    .agent-better-img-first {
        max-width: 87px;
        max-height: 87px;
        border-radius: 50%;
    }

    .agent-better-1 .fa-chess-queen {
        position: absolute;
        bottom: 0;
        transform: translate(0, 35%);
        color: var(--light-orange-panel) !important;
        fill: var(--light-orange-panel) !important;

    }

    .agent-better-1 .agent-better-rank {
        background-color: transparent !important;
        color: #fff;

    }

    .agent-better-img {
        max-width: 65px;
        max-height: 65px;
        border-radius: 50%;
    }

    .agent-more {
        height: 147px;
        overflow: scroll;
    }

    .table-agent-header {
        font-size: 12px;
        color: var(--dark-text-panel);
        padding: 0 7px !important;
    }

    .table-agent-body .agent-better-img,
    .agent-me-img {
        max-width: 38px;
        max-height: 38px;
        border-radius: 50%;
    }

    .agent-rankme-right {
        display: flex;
        align-items: center;
        padding-right: 20px;
        gap: 34px;
    }

    .table-agent-headers {
        border-bottom: 1px solid #E7E7E7 !important;
    }

    .panel-activity {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #E7E7E7;
        padding: 13px 0;
    }

    .panel-activity:last-child {
        border: 0;
        padding-bottom: 0;
    }

    .panel-activity-num {
        font-size: 24px;
        color: var(--color-primary-panel);
        width: 17%;
    }

    .panel-activity-text {
        font-size: 15px;
        color: var(--dark-text-panel);
        width: 50%;
    }

    .panel-activity-more {
        font-size: 15px;
        color: #8C81D7;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: end;
        gap: 10px;
        width: 33%;
        white-space: nowrap;
    }

    .panel-goals-p {
        font-size: 16px;
    }

    .panel-select {
        font-size: 14px;
        border: 0;
        color: var(--color-primary-panel);
        direction: ltr;
        cursor: pointer;
    }

    .panel-link-more {
        font-size: 14px;
        color: var(--color-primary-panel);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-link-more2 {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        color: var(--color-primary-panel);
        font-size: 19px;
    }

    .panel-link-more:hover,
    .panel-link-more2:hover {
        color: var(--color-primary-panel) !important;
    }

    .panel-link-more .fa-arrow-left {
        color: var(--dark-text-panel);
        font-size: 20px;
    }

    .panel-form {
        border: 1px solid #E7E7E7;
        border-radius: 25px;
        text-align: center;
        padding: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-form:focus {
        border: 1px solid red;
    }

    .panel-form-input {
        width: 60%;
    }

    .panel-walet {
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--dark-text-panel);
    }

    .panel-walet2 {
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--dark-text-panel);
    }

    .panel-edit {
        color: var(--color-primary-panel);
    }

    .panel-edit:hover {
        color: var(--color-primary-panel) !important;
    }

    .panel-performance-box {
        border: 1px solid #E7E7E7;
        border-radius: 24px;
        min-height: 55px;
        padding: 0 10px;
        color: var(--dark-text-panel);
        margin-bottom: 5px;
    }

    .panel-performance-box:last-child {
        margin-bottom: 0;
    }

    .panel-performance {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .performance-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 5px 0;
    }

    .performance-header {
        font-size: 14px;
        padding-right: 14px;
    }

    .visit-registration {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .visit-icon {
        width: 25px;
        height: 24px;
        border-radius: 100px;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 300;
        cursor: pointer;
    }

    .visit-icon.fa-plus {
        background-color: #8DD781;
    }

    .visit-icon.fa-minus {
        background-color: var(--dark-orange-panel);
    }

    .panel-up {
        cursor: pointer;
    }

    .panel-form-muted {
        color: var(--light-text-panel);
        font-weight: 300;
        font-size: 14px;
    }

    .panel-tip {
        font-size: 15px;
        line-height: 2;
        color: #292B2E;
    }

    .icon-left {
        font-size: 22px;
        color: var(--dark-text-panel);
    }

    .panel-admin-body .fa-chess-queen {
        font-size: 44px;
        color: var(--light-text-panel);
        font-weight: 100;
    }

    .panel-buyer-box {
        background-color: var(--background-panle);
        padding: 12px;
        width: 300px;
        border-radius: 20px;
        margin-top: 17px;
        margin-bottom: 7px;
        min-height: 230px;
    }

    .panel-news-box {
        background-color: var(--background-sidebar);
        width: 325px;
        min-height: 236px;
        padding: 12px;
        border-radius: 20px;
    }

    .panel-allnews {
        width: 300px;
        border-radius: 20px;
        margin-top: 17px;
        background-color: #fff;
    }

    .panel-news-img {
        background: url("https://www.mpconf.ir/files_site/news/r_44_210508085347.jpg");
        width: 100%;
        height: 150px;
        background-size: cover;
        border-radius: 20px;
    }

    .panel-last-slider {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--color-primary-panel);
        gap: 10px;
    }

    .panel-news-link:hover {
        color: var(--color-primary-panel) !important;
    }

    .progress {
        width: 100%;
        padding: 0;
        border-radius: 24px;
        background-color: #F4F6FC;
        border: 1px solid #E7E7E7;
        height: 20px;
        position: relative;
    }

    .progress-bar {
        border-radius: 25px;
        background-color: var(--color-primary-panel);
    }

    .progress-detail {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        color: var(--dark-text-panel);
    }

    .news-img {
        width: 100%;
        border-radius: 20px;
    }

    .buyer-img-box {
        position: relative;
    }

    .buyer-img {
        width: 280px;
        height: 153px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .buyer-back {
        background-color: var(--dark-orange-panel);
        padding: 0 7px;
        border-radius: 20px;
    }

    .buyer-p {
        position: absolute;
        bottom: 0;
        color: #fff;
        font-size: 18px;
        padding: 60px 8px 8px;
        margin: 0;
        font-weight: 300;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(35, 32, 54, 0.251754) 20%, #5C5C5C 100%);
        border-radius: 0 0 20px 20px;
    }

    .new-p {}

    .panel-todo-list {
        position: relative;
    }

    .todo-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: var(--background-sidebar);
        padding: 8px;
        border-radius: 0 0 25px 25px;
        border-top: 1px solid #E7E7E7;
        width: 100%;
    }

    .todo-box {
        display: flex;
        justify-content: space-between;
        background-color: #fff;
        padding: 4px;
        border-radius: 40px;
        border: 1px solid #E7E7E7;
    }


    .todo-list-add-btn,
    .todo-list-input {
        font-size: 14px !important;
        font-weight: 300;
    }

    .todo-list-input:focus {
        border: 0 !important;
        /* color: transparent !important */
    }

    .mdi:before {

        color: var(--dark-orange-panel);
        font-style: normal;
        font-weight: 300;
        font-size: 19px;
    }

    .form-check .form-check-label input[type="checkbox"]+.input-helper:before {
        content: "";
        width: 18px;
        height: 18px;
        border-radius: 7px;
        border: solid #405189;
        border: 1px solid #8C81D7;
        /* border-width: 2px; */
        -webkit-transition: all;
        -moz-transition: all;
        -ms-transition: all;
        -o-transition: all;
        transition: all;
        transition-duration: 0s;
        -webkit-transition-duration: 250ms;
        transition-duration: 250ms;
    }

    .todo-list-input {
        width: 100%;
        color: #000 !important;
        border: 0;
        margin-right: 10px;
    }

    .list-wrapper {
        min-height: 200px;
        height: 200px;
        overflow-y: scroll;
    }

    .list-wrapper .completed {
        text-decoration: line-through;
        text-decoration-color: var(--light-text-panel) !important;
    }

    .todo-list-item.completed {
        color: var(--light-text-panel) !important;
    }

    .todo-list-item.completed .mdi:before {
        color: var(--light-text-panel) !important;
    }

    .form-check .form-check-label input[type="checkbox"]:checked+.input-helper:before {
        background: var(--light-text-panel) !important;
        border-width: 0;
    }

    .progress-titr {
        font-size: 14px;
        color: var(--dark-text-panel);
        text-align: center;
    }

    .progress-chart {
        position: relative;
    }

    .progress-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 25px;
        color: var(--color-primary-panel);
        display: flex;
        flex-direction: column;
        align-items: center;

    }

    .progress-circle-text {
        color: var(--dark-text-panel);
        font-size: 15px;
    }

    .panel-property {
        width: 350px;
    }

    .panel-adver {
        height: 360px;
        padding: 0;
        overflow: hidden;
    }

    .panel-adver-img {
        width: 100%;
        height: 100%;
    }

    .panel-property-box {
        background-color: var(--background-panle);
        border-radius: 24px;
        padding: 19px 15px;
        margin: 10px 0 10px 10px;
    }

    .panel-property-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .panel-property-home {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        color: var(--dark-text-panel);
    }

    .item {
        width: 100px;
        height: 100px;
        background-color: red;

    }

    #monthly_income {
        width: 22% !important;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: inherit;
        border-style: inset;
        border-width: 0;
    }

    .panelactivity {
        font-size: 24px;
        color: var(--color-primary-panel);
        width: 0%;
    }

    @media (max-width:768px) {

        .panel-adver {
            height: auto;
        }

        .panel-admin-box {
            min-height: auto;
        }

        .panel-property {
            width: 320px;
        }

        .admin-box2 {
            min-height: 250px;
        }

        .btn-admin-px {
            padding: 6px 25px;
        }

        .panel-link-more {
            font-size: 13px;
        }

        #monthly_income {
            width: 65% !important;
        }

        .list-wrapper {
            min-height: auto;
            height: auto;
            overflow-y: scroll;
        }

        .fa-angle-left::before {
            content: "\f104";
            color: var(--color-primary-panel);
            position: absolute;
            left: 12px;
            font-size: 36px;
            font-weight: 300;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }
    }

    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel button.owl-dot {
        background: var(--background-panle);
        width: 40px;
        height: 40px;
        border-radius: 80px;
        font-size: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--color-primary-panel);
        border: 1px solid #E7E7E7;

    }

    .owl-carousel {
        position: relative;
    }

    .owl-prev {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translate(50%, -50%);
    }

    .owl-next {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translate(-50%, -50%);
    }

    .owl-nav button.disabled {
        opacity: 0;
        cursor: default !important;
    }

    @media (max-width:500px) {
        #monthly_income {
            width: 45% !important;
        }
    }

    .dashboard-top-box {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: scroll;
    }

    .dashboard-top {
        width: 100%;
        background-color: #fff;
    }

    .dashboard-top-title {
        font-size: 20px;
        color: var(--dark-text-panel);
        padding: 12px 20px;
        width: 130px;
        /* background-color: blue; */
        white-space: nowrap;
        /* margin-left: 25px; */
    }

    .panel-activity-mob {
        width: 100%;
        background-color: #fff;
        padding: 8px 20px;
        border: 1.78102px solid #E7E7E7;
    }

    .panel-activity-item {
        width: 160px;
        height: 140px;
        padding: 10px 0;
        background-color: var(--background-sidebar);
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        border: 1.81006px solid #E7E7E7;
        margin: 0 10px;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 466px;
            max-height: 419px;
            margin: 1.75rem auto;

        }
    }

    .container1 {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 17px;
        color: 5C5C5C;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container1 input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .container1 input:checked~.checkmark {
        background-color: #2196F3;
    }

    .container1:hover input~.checkmark {
        background-color: #ccc;
    }

    .checkmark {
        position: absolute;
        top: 0;
        width: 22px;
        height: 22px;

        border: 0.961261px solid #A3A3A3;
        box-sizing: border-box;
        border-radius: 5px;
    }

    /* On mouse-over, add a grey background color */


    /* When the checkbox is checked, add a blue background */


    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {

        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container1 input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container1 .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
    }

    .modal-content {
        background: #F8F8F8;
        border: 1px solid #E7E7E7;
        box-sizing: border-box;
        border-radius: 25px;
    }
</style>
@endsection
@section('main_content')
@include('frontend.layouts.header1')
<div class="dashboard-top d-sm-block d-md-none mb-2 py-3">
    <div class="owl-carousel owl-theme dashboard-top-mob" id="dashboard-top-mob">
        <a href="/dashboard_v2" class="dashboard-top-title">{{ l('پیشخوان') }}</a>
        <a href="/profile/my-estate-ads" class="dashboard-top-title">{{ l('ملک های من') }}</a>

        <a href="/chats" class="dashboard-top-title">{{ l('گفتگوها') }}</a>
    </div>
</div>
<div class="panel-activity-mob d-sm-block d-md-none">
    <div class="panel-admin-header">
        <div class="panel-header-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 512">
                <path d="M640 240C640 248.8 632.8 256 624 256h-133.1l-60 150c-2.625 6.375-8.375 10.25-16 9.1C408 415.5 402.1 410.6 400.5 403.9l-78.75-315l-82 410.3C238.3 506.5 231.9 511.8 224.4 512H224c-7.25 0-13.75-5-15.5-12.12L147.5 256H16C7.201 256 0 248.8 0 240s7.201-15.1 16-15.1H160c7.375 0 13.75 4.993 15.5 12.12l46.75 187l82-410.3C305.8 5.5 312 .25 319.5 0c8.125 .125 14.25 4.875 16 12.12l84 336l45.63-114.1C467.5 228 473.5 224 480 224h144C632.8 224 640 231.2 640 240z" />
            </svg>
            <span>{{ l('وضعیت فعالیت من') }}</span>
        </div>
        <div class="panel-header-left">
            <select class="panel-select" name="" id="">
                <option value="">{{ l('وضعیت ماه') }}</option>
                <option value="">{{ l('وضعیت سال') }}</option>
            </select>
        </div>
    </div>
    <div class="panel-admin-body my-2">
        <div class="owl-carousel owl-theme activity-mob" id="activity-mob">
            <div class="panel-activity-item">
                <div class="d-flex flex-column align-items-center px-2">
                    <span class="panel-activity-num w-auto"></span>
                    <span class="panel-activity-text w-auto text-center">{{ l('ملک سپرده‌ام') }}

                    </span>
                </div>
                <a class="panel-activity-more justify-content-center" href="/add">
                    {{ l('سپردن ملک') }}
                    <i class="fal fa-chevron-left "></i>
                </a>
            </div>
            <div class="panel-activity-item">
                <div class="d-flex flex-column align-items-center px-2">
                    <span class="panel-activity-num w-auto"></span>
                    <span class="panel-activity-text w-auto text-center">{{ l('خریدار ثبت کرده‌ام') }}</span>
                </div>
                <a class="panel-activity-more justify-content-center" href="/customers/create">
                    {{ l('ثبت خریدار') }}
                    <i class="fal fa-chevron-left "></i>
                </a>
            </div>
            <div class="panel-activity-item">
                <div class="d-flex flex-column align-items-center px-2">
                    <span class="panel-activity-num w-auto"></span>
                    <span class="panel-activity-text w-auto text-center">{{ l('کارشناس یا شعبه جذب کرده‌ام') }}</span>
                </div>
                <a class="panel-activity-more justify-content-center" href="#">
                    {{ l('مشاهده لیست') }}
                    <i class="fal fa-chevron-left "></i>
                </a>
            </div>
            <div class="panel-activity-item">
                <div class="d-flex flex-column align-items-center px-2">
                    <span class="panel-activity-num w-auto">54</span>
                    <span class="panel-activity-text w-auto text-center">{{ l('قولنامه انجام داده‌ام') }}</span>
                </div>
                <a class="panel-activity-more justify-content-center" href="#">
                    {{ l('لیست قولنامه‌ها') }}
                    <i class="fal fa-chevron-left "></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container content-box">
    <div class="row">
        <div class="col-lg-3 d-none d-lg-block mt-3">
            <div class="sidebar-admin-box border-panel mb-4">
                <div class="sidebar-profile text-center mt-4">
                    <div class="sideprof">
                        <div class="sidebar-profile-img">
                            <img class="profile-img" src="{{$currentUser->photo()}}" alt="">
                            <a class="sidebar-profile-edit" href="#">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                    </div>
                    <h6 class="sidebar-profile-name">{{$currentUser->fullname()}}</h6>
                    <p class="sidebar-profile-agent">{{$currentUser->isAdminSuper()? l('مدیر سایت'):''}} {{$currentUser->isExpert()? l('کارشناس'):''}} {{$currentUser->{{ l('isAdminBranch()?\'مدیر شعبه\':\'\'}}') }} </p>

                </div>
                <div class="sidebar-item-box">
                    <ul class="sidebar-item">
                        <li class="sidebar-list active">
                            <a class="sidebar-link " href="/dashboard_v2">
                                <svg class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M176 0h-128C21.49 0 0 21.49 0 48v128C0 202.5 21.49 224 48 224h128C202.5 224 224 202.5 224 176v-128C224 21.49 202.5 0 176 0zM464 288h-128C309.5 288 288 309.5 288 336v128c0 26.51 21.49 48 48 48h128c26.51 0 48-21.49 48-48v-128C512 309.5 490.5 288 464 288zM464 0h-128C309.5 0 288 21.49 288 48v128C288 202.5 309.5 224 336 224h128C490.5 224 512 202.5 512 176v-128C512 21.49 490.5 0 464 0zM176 288h-128C21.49 288 0 309.5 0 336v128C0 490.5 21.49 512 48 512h128C202.5 512 224 490.5 224 464v-128C224 309.5 202.5 288 176 288z" />
                                </svg>
                                <span>{{ l('پیشخوان') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-badge-item" href="/profile/my-estate-ads">
                                <svg class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M184 128h-144C17.94 128 0 145.9 0 168v336C0 508.4 3.594 512 8 512s8-3.594 8-8V168c0-13.22 10.78-24 24-24h144c13.22 0 24 10.78 24 24v336C208 508.4 211.6 512 216 512S224 508.4 224 504V168C224 145.9 206.1 128 184 128zM304 88h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C328 98.78 317.2 88 304 88zM312 144c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V144zM472 0h-256C193.9 0 176 17.94 176 40v48C176 92.41 179.6 96 184 96S192 92.41 192 88v-48C192 26.78 202.8 16 216 16h256c13.22 0 24 10.78 24 24v464c0 4.406 3.594 8 8 8S512 508.4 512 504V40C512 17.94 494.1 0 472 0zM128 328H96c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C152 338.8 141.2 328 128 328zM136 384c0 4.5-3.5 8-8 8H96c-4.5 0-8-3.5-8-8v-32c0-4.5 3.5-8 8-8h32c4.5 0 8 3.5 8 8V384zM432 344h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C456 354.8 445.2 344 432 344zM440 400c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V400zM128 200H96C82.78 200 72 210.8 72 224v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24V224C152 210.8 141.2 200 128 200zM136 256c0 4.5-3.5 8-8 8H96C91.5 264 88 260.5 88 256V224c0-4.5 3.5-8 8-8h32c4.5 0 8 3.5 8 8V256zM304 216h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C328 226.8 317.2 216 304 216zM312 272c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V272zM432 216h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C456 226.8 445.2 216 432 216zM440 272c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V272zM432 88h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C456 98.78 445.2 88 432 88zM440 144c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V144zM304 344h-32c-13.22 0-24 10.78-24 24v32c0 13.22 10.78 24 24 24h32c13.22 0 24-10.78 24-24v-32C328 354.8 317.2 344 304 344zM312 400c0 4.406-3.594 8-8 8h-32c-4.406 0-8-3.594-8-8v-32c0-4.406 3.594-8 8-8h32c4.406 0 8 3.594 8 8V400z" />
                                </svg>
                                <span>{{ l('ملک های من') }}</span>
                            </a>

                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-badge-item" href="/customer">
                                <svg class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M505.8 233.4l-105.4-179.2C392.3 40.52 377.5 32 361.4 32H150.6C134.5 32 119.7 40.52 111.6 54.17l-105.4 179.2c-8.234 14-8.234 31.27 0 45.27l105.4 179.2C119.7 471.5 134.5 480 150.6 480h210.8c16.12 0 30.94-8.518 39.05-22.17l105.4-179.2C514.1 264.6 514.1 247.4 505.8 233.4zM492 270.5l-105.3 179.1C381.4 458.5 371.7 464 361.4 464H150.6c-10.34 0-20.04-5.496-25.26-14.28l-105.4-179.2c-5.268-8.959-5.268-20.09 .002-29.04l105.3-179.1C130.6 53.5 140.3 48 150.6 48h210.8c10.35 0 20.04 5.496 25.26 14.28l105.4 179.2C497.3 250.4 497.3 261.6 492 270.5zM320 272c-3.479 0-6.855 .4141-10.13 1.121l-28.92-72.31C294.7 192.4 304 177.3 304 160c0-26.47-21.53-48-48-48S208 133.5 208 160c0 12.79 5.102 24.35 13.28 32.96l-39.42 52.55C175.3 242.1 167.9 240 160 240C133.5 240 112 261.5 112 288s21.53 48 48 48c20.43 0 37.79-12.88 44.71-30.9l67.43 13.49C272.1 319.1 272 319.5 272 320c0 26.47 21.53 48 48 48s48-21.53 48-48S346.5 272 320 272zM256 128c17.66 0 32 14.36 32 32s-14.34 32-32 32S224 177.6 224 160S238.3 128 256 128zM160 320c-17.66 0-32-14.36-32-32s14.34-32 32-32s32 14.36 32 32S177.7 320 160 320zM275.3 302.9L207.9 289.4C207.9 288.9 208 288.5 208 288c0-12.78-5.1-24.35-13.28-32.96l39.41-52.56C240.7 205.9 248.1 208 256 208c3.479 0 6.855-.4141 10.12-1.121l28.93 72.31C286.1 284.7 279.1 292.1 275.3 302.9zM320 352c-17.66 0-32-14.36-32-32s14.34-32 32-32s32 14.36 32 32S337.7 352 320 352z" />
                                </svg>
                                <span>{{ l('خریداران من') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link" href="/profile/expertlevel">
                                <svg class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M505.8 233.4l-105.4-179.2C392.3 40.52 377.5 32 361.4 32H150.6C134.5 32 119.7 40.52 111.6 54.17l-105.4 179.2c-8.234 14-8.234 31.27 0 45.27l105.4 179.2C119.7 471.5 134.5 480 150.6 480h210.8c16.12 0 30.94-8.518 39.05-22.17l105.4-179.2C514.1 264.6 514.1 247.4 505.8 233.4zM492 270.5l-105.3 179.1C381.4 458.5 371.7 464 361.4 464H150.6c-10.34 0-20.04-5.496-25.26-14.28l-105.4-179.2c-5.268-8.959-5.268-20.09 .002-29.04l105.3-179.1C130.6 53.5 140.3 48 150.6 48h210.8c10.35 0 20.04 5.496 25.26 14.28l105.4 179.2C497.3 250.4 497.3 261.6 492 270.5zM320 272c-3.479 0-6.855 .4141-10.13 1.121l-28.92-72.31C294.7 192.4 304 177.3 304 160c0-26.47-21.53-48-48-48S208 133.5 208 160c0 12.79 5.102 24.35 13.28 32.96l-39.42 52.55C175.3 242.1 167.9 240 160 240C133.5 240 112 261.5 112 288s21.53 48 48 48c20.43 0 37.79-12.88 44.71-30.9l67.43 13.49C272.1 319.1 272 319.5 272 320c0 26.47 21.53 48 48 48s48-21.53 48-48S346.5 272 320 272zM256 128c17.66 0 32 14.36 32 32s-14.34 32-32 32S224 177.6 224 160S238.3 128 256 128zM160 320c-17.66 0-32-14.36-32-32s14.34-32 32-32s32 14.36 32 32S177.7 320 160 320zM275.3 302.9L207.9 289.4C207.9 288.9 208 288.5 208 288c0-12.78-5.1-24.35-13.28-32.96l39.41-52.56C240.7 205.9 248.1 208 256 208c3.479 0 6.855-.4141 10.12-1.121l28.93 72.31C286.1 284.7 279.1 292.1 275.3 302.9zM320 352c-17.66 0-32-14.36-32-32s14.34-32 32-32s32 14.36 32 32S337.7 352 320 352z" />
                                </svg>
                                <span>{{ l('بازاریابی') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-badge-chat" href="/chats">
                                <svg class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M447.1 15.1c26.47 0 48 21.53 48 47.1v287.1c0 26.46-21.53 47.1-48 47.1h-149.3l-122.7 92.08v-92.08H63.1c-26.47 0-48-21.53-48-47.1v-287.1c0-26.46 21.53-47.1 48-47.1H447.1zM447.1 0h-384c-35.25 0-64 28.75-64 63.1v287.1c0 35.25 28.75 63.1 64 63.1h96v83.98C159.1 507 165.9 512 172.2 512c2.369 0 4.786-.7454 6.948-2.323l124.9-93.68h144c35.25 0 64-28.75 64-63.1V63.1C511.1 28.75 483.2 0 447.1 0z" />
                                </svg>
                                <span>{{ l('گفتگوها') }}</span>
                            </a>

                        </li>
                        <li class="sidebar-list ">
                            <a class="sidebar-link" href="/logout">
                                <svg width="24" height="24" class="icon-sidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M176 448h-96C53.53 448 32 426.5 32 400v-288C32 85.53 53.53 64 80 64h96C184.8 64 192 56.84 192 48S184.8 32 176 32h-96C35.88 32 0 67.88 0 112v288C0 444.1 35.88 480 80 480h96C184.8 480 192 472.8 192 464S184.8 448 176 448zM502.6 233.4l-128-128c-9.156-9.156-22.91-11.91-34.88-6.938C327.8 103.4 320 115.1 320 128l.0918 63.1L176 192C149.5 192 128 213.5 128 240v32C128 298.5 149.5 320 176 320l144.1-.001L320 384c0 12.94 7.797 24.62 19.75 29.56c11.97 4.969 25.72 2.219 34.88-6.938l128-128C508.9 272.4 512 264.2 512 256S508.9 239.6 502.6 233.4zM352 384V288H176C167.2 288 160 280.8 160 272v-32C160 231.2 167.2 224 176 224H352l-.0039-96l128 128L352 384z" />
                                </svg>
                                <span>{{ l('خروج') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12 my-3">

            <form method="POST" id="form1" action="{{url('/profile/info/update1')}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-12 d-none d-md-block">
                        <div class="header-panel my-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="title-page">
                                    {{ l('اطلاعات پروفایل') }}
                                </div>
                                <div class="d-flex gap-3">
                                    <a href="/customers/create" class="btn btn-info btn-admin-white">{{ l('ثبت خریدار') }}</a>
                                    <a href="/add" class="btn btn-info btn-admin">{{ l('سپردن ملک') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="row">
                            <div class="col-md-12 col-12 mb-2  d-none d-md-block">
                                <div class="panel-admin-box">
                                    <div class="row p-2">
                                        <div class="row p-2">
                                            <div class="col-lg-3 col-md-4 col-sm-12 form-group ">
                                                <input type="hidden" name="images1" class="images1" />
                                                <input type="hidden" name="images2" class="images2" />
                                                <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
                                                <input type="hidden" name="profile_covershow" class="profile_cover1" value="{{!empty($currentUser)?0:1}}" />
                                                <input type="hidden" name="districts" id="district_id" class="district_id">
                                                <label for="photo" class="control-label col-title mt-1 mb-1">{{ l('بارگزاری تصویر پروفایل') }}</label>

                                                <div class="text-center" style="position:relative">

                                                    <div class='card-img-box card1 borderblack'>

                                                        <div style="position:absolute;right: 12px;z-index: 1;top: 10px" class="editprofile1 d-none">
                                                            <a onclick="document.getElementById('photo1').click()"><label for="imageUpload" class="pen"></label></a>
                                                        </div>

                                                        <div class="uploadprofile1 d-none" style="position:absolute;top:40px;width:156px">
                                                            <a class="text-light mt-3" style="width:100%" onclick="document.getElementById('photo1').click()">
                                                                <img src="/upload/images/upload.png" style="margin:0 auto" />
                                                            </a>
                                                        </div>
                                                        <div class="gradiantover d-none">
                                                            <div class="graddelete"><i class='fas fa-times delprofile' style='color: red'></i></div>
                                                        </div>
                                                        <img src="{{ old('photo',$currentUser->photo()) }}" style="border-radius: 50%;width: 159px;height: 159px;" class="{{empty($currentUser->photo())?'d-none':''}}" id="preview" />
                                                    </div>
                                                </div>



                                                <input type="file" name="image" class="image" id="photo1" accept=".jpg,.png,.jpeg" style="display:none">
                                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="justify-content:center;align-items: center;">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="">
                                                                <div class="img-container">
                                                                    <div class="row">
                                                                        <div style="width:80%;margin:0 auto">
                                                                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                                                        </div>
                                                                        <div style="display:none" class="preview"></div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-black" id="cancel" data-dismiss="modal">{{ l('انصراف') }}</button>
                                                                <button type="button" class="btn btn-primary" id="crop">{{ l('بریدن') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="row p-2">
                                            <!--div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100">{{ l('نام مستعار') }}</div><input type="text" value="{{$currentUser->title}}" name="title" id="title" class="w-100 form-control" style="border-radius:15px;height:50px" />
                                                <div style="font-size:13px;color:gray">{{ l('این عنوان به جای نام اصلی شما در پروفایل و بر روی ملک های ثبت شده خواهد شد.') }}</div>
                                            </div-->
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100 ">{{ l('شماره موبایل') }}</div><input value="{{$currentUser->phone}}" name="phone" id="phone" type="text" class="w-100  form-control" style="border-radius:15px;height:50px" />
                                                <div style="font-size:13px;color:gray">{{ l('این شماره تلفن در ملک های شما ثبت میگردد و دیگران با این شماره با شما در ارتباط خواهد بود.') }}</div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100">{{ l('محله های فعالیت') }}</div>
                                                <div class="w-100">

                                                    <div style="float:right;margin:3px;" id="districtaction"></div>

                                                    <div class="select2-selection__plus plus1" title="">
                                                        <i class="fa fa-plus" id="plus1" style="font-weight: 1;font-size:35px;padding-top:5px" aria-hidden="true"></i>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100 ">{{ l('نوع ملک') }}</div>
                                                <div class="w-100">
                                                    <div style="float:right;margin:3px;" id="buildingaction"></div>


                                                    <div class="select2-selection__plus plus2" title="">
                                                        <i class="fa fa-plus" id="plus2" style="font-weight: 1;font-size:35px;padding-top:5px" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <input type="hidden" id="activity_type" name="activity_type" />
                                        <div class="row p-2">
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100">{{ l('نوع فعالیت') }}</div>
                                                <div class="w-100 mt-1">
                                                    <div class="d-flex justify-content-center dcircle  sell {{!empty($currentUser->activity_type)?(($currentUser->activity_type == 1 || $currentUser->activity_type == 3)?'actived':'deactive'):''}} actionclick" style=" " title="{{ l('فروش') }}">
                                                        <i class="fa fa-circle float-right  mt-1 pml_5 " aria-hidden="true"></i>
                                                        <span class="dcirlecontent ">
                                                            {{ l('فروش') }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex justify-content-center dcircle  buy actionclick {{!empty($currentUser->activity_type)?(($currentUser->activity_type == 2 || $currentUser->activity_type == 3)?'actived':'deactive'):''}}" title="{{ l('اجاره') }}">
                                                        <i class="fa fa-circle float-right mt-1  pml_5 " aria-hidden="true"></i>
                                                        <span class="dcirlecontent">
                                                            {{ l('اجاره') }}
                                                        </span>
                                                    </div>



                                                </div>
                                            </div>
                                            <!--div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                                <div class="w-100">{{ l('نام کاربری (آدرس پروفایل)') }}</div>
                                                <div class="w-100 mt-3" style="min-height:60px">
                                                    <input class="color_5C5C5C" style="border: 0.961261px solid #A3A3A3;box-sizing: border-box;border-radius: 23.0703px;height:48px;float:right;;padding-top:8px;padding-bottom:8px;text;font-size:18px;direction:ltr;text-align:center" name="alias" id="alias" value="{{$currentUser->alias}}" {{$currentUser->alias_status?'disabled':''}} />
                                                    <div style="float:right;direction:ltr;font-size:18px;padding-top:9px" class="color_A3A3A3">{{env('APP_URL')}}/agents/ </div>
                                                </div>
                                                <div class="w-100 color_5C5C5C " style="clear:both;font-size:12px;">
                                                    {{ l('حداقل 4 کاراکتر شامل حروف انگلیسی, کارکتر " - " و اعداد ؛ صرفا مجاز می‌باشد.') }}
                                                </div>
                                            </div-->
                                        </div>


                                        <div class="row p-2 w-100 d-flex justify-content-end">
                                            <button type="submit" class="text-white text-center" onclick="show()" style=";background: #025EC6;border-radius: 24px;width:232px;height:47px;font-size:18px;padding-top:10px">{{ l('ذخیره') }}</button>



                                        </div>
                                    </div>


                                </div>
                            </div>

                            {{-- <div class="col-md-8 col-12 mb-2 goals-performance">
                    <div class="panel-admin-box ">
                        <div class="panel-admin-header">
                            <div class="panel-header-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M123.3 315.3L224 214.6l84.67 84.67c6.248 6.248 16.38 6.248 22.62 .002l144-143.1c6.25-6.248 6.25-16.38 .002-22.62s-16.38-6.248-22.62 0L320 265.4L235.3 180.7c-6.223-6.225-16.4-6.225-22.63-.002l-112 112c-6.234 6.234-6.234 16.39 0 22.62C106.9 321.6 117.1 321.6 123.3 315.3zM496 448h-416C53.53 448 32 426.5 32 400v-352C32 39.17 24.83 32 16 32S0 39.17 0 48v352C0 444.1 35.88 480 80 480h416c8.828 0 16-7.172 16-16S504.8 448 496 448z" />
                                </svg>
                                <span>{{ l('هدف عملکرد ماهانه') }}</span>
                            </div>
                        </div>



    </div>

</div>
<div class="col-md-8 col-12 mb-2 monthly-performance d-none">
    <div class="panel-admin-box">
        <div class="panel-admin-header">
            <div class="panel-header-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                    <path d="M123.3 315.3L224 214.6l84.67 84.67c6.248 6.248 16.38 6.248 22.62 .002l144-143.1c6.25-6.248 6.25-16.38 .002-22.62s-16.38-6.248-22.62 0L320 265.4L235.3 180.7c-6.223-6.225-16.4-6.225-22.63-.002l-112 112c-6.234 6.234-6.234 16.39 0 22.62C106.9 321.6 117.1 321.6 123.3 315.3zM496 448h-416C53.53 448 32 426.5 32 400v-352C32 39.17 24.83 32 16 32S0 39.17 0 48v352C0 444.1 35.88 480 80 480h416c8.828 0 16-7.172 16-16S504.8 448 496 448z" />
                </svg>
                <span>{{ l('برنامه عملکرد ماهانه') }}</span>
            </div>
            <div class="panel-edit monthly-performance-edit">
                <i class="fal fa-edit "></i>
            </div>
        </div>
        <div class="panel-admin-body">
            <div class="row">
                <div class="col-md-8 col-12 mt-2">
                    <div class="panel-performance-box">
                        <span class="performance-header">{{ l('ثبت ملک') }}</span>
                        <div class="panel-performance">
                            <div class="progress">

                                <div class="progress-bar" role="progressbar" style="width:" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-detail">
                                        <span></span>
                                        {{ l('از') }}
                                        <span></span>
                                    </div>
                                </div>
                            </div>

                            <span class="performance-header"></span>
                        </div>
                    </div>
                    <div class="panel-performance-box">
                        <span class="performance-header">{{ l('ثبت خریدار') }}</span>
                        <div class="panel-performance">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-detail">
                                        <span></span>
                                        {{ l('از') }}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <span class="performance-header"></span>
                        </div>
                    </div>
                    <div class="panel-performance-box">
                        <input type="hidden" id="visit" value="" />
                        <div class="performance-header-box">
                            <span class="performance-header">{{ l('بازدید') }}</span>
                            <div class="visit-registration">
                                <p class="performance-header m-0 text-panel-primary ">{{ l('ثبت بازدید:') }}</p>
                                <i class="visit-icon fal fa-minus"></i>
                                <i class="visit-icon fal fa-plus"></i>
                            </div>

                        </div>
                        <div class="panel-performance mb-2  ">
                            <div class="progress">
                                <div class="progress-bar" id="progressvisit" role="progressbar" style="width:50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-detail">
                                        <span id="visit1"></span>
                                        {{ l('از') }}
                                        <span>10</span>
                                    </div>
                                </div>
                            </div>
                            <span class="performance-header" id="visitpercent"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mt-2 text-center">
                    <p class="progress-titr">{{ l('قولنامه ها') }}</p>
                    <div onclick="GoToTop()" class="progress-chart" id="graph" data-percent="30">
                        <span class="progress-circle">
                            <span>3</span>
                            <span class="progress-circle-text">{{ l('از') }}</span>
                            <span>6</span>
                        </span>

                        <canvas id="canv" height="50" width="50"><span id="siz1"></span></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 col-12 mb-2 goals-income">
    <div class="panel-admin-box">
        <div class="panel-admin-header">
            <div class="panel-header-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                    <path d="M123.3 315.3L224 214.6l84.67 84.67c6.248 6.248 16.38 6.248 22.62 .002l144-143.1c6.25-6.248 6.25-16.38 .002-22.62s-16.38-6.248-22.62 0L320 265.4L235.3 180.7c-6.223-6.225-16.4-6.225-22.63-.002l-112 112c-6.234 6.234-6.234 16.39 0 22.62C106.9 321.6 117.1 321.6 123.3 315.3zM496 448h-416C53.53 448 32 426.5 32 400v-352C32 39.17 24.83 32 16 32S0 39.17 0 48v352C0 444.1 35.88 480 80 480h416c8.828 0 16-7.172 16-16S504.8 448 496 448z" />
                </svg>
                <span>{{ l('هدف درآمد ماهانه') }}</span>
            </div>
        </div>
        <div class="panel-admin-body mt-4 px-2">
            <p class="panel-goals-p text-orange ">{{ l('چه میزان درآمد تا آخر اسفند ماه می خواهید کسب کنید؟') }}</p>
            <p class="text-panel">{{ l('درآمد مدنظر') }}</p>
            <form class="panel-form" action="">
                <input id="monthly_income" type="number" min="0" class="panel-form-input w-100 border-0">
                <span class="panel-form-muted">{{ l('میلیون تومان') }}</span>
                <button class="btn btn-info btn-admin btn-admin-px btn-panel px-3" type="button" id="income-target">{{ l('ثبت') }}</button>
            </form>
        </div>
    </div>
</div>
<div class="col-md-4 col-12 mb-2 monthly-income d-none">
    <div class="panel-admin-box">
        <div class="panel-admin-header">
            <div class="panel-header-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                    <path d="M123.3 315.3L224 214.6l84.67 84.67c6.248 6.248 16.38 6.248 22.62 .002l144-143.1c6.25-6.248 6.25-16.38 .002-22.62s-16.38-6.248-22.62 0L320 265.4L235.3 180.7c-6.223-6.225-16.4-6.225-22.63-.002l-112 112c-6.234 6.234-6.234 16.39 0 22.62C106.9 321.6 117.1 321.6 123.3 315.3zM496 448h-416C53.53 448 32 426.5 32 400v-352C32 39.17 24.83 32 16 32S0 39.17 0 48v352C0 444.1 35.88 480 80 480h416c8.828 0 16-7.172 16-16S504.8 448 496 448z" />
                </svg>
                <span>{{ l('هدف درآمد ماهانه') }}</span>
            </div>
            <a class="panel-edit monthly-income-edit" href="#">
                <i class="fal fa-edit"></i>
            </a>
        </div>
        <div class="panel-admin-body text-center my-4 px-2">
            <div onclick="GoToTop()" class="progress-chart" id="graph1" data-percent="30">
                <span class="progress-circle">
                    <span>5</span>
                    <span class="progress-circle-text">{{ l('میلیون از') }}</span>
                    <span>10</span>
                </span>

                <canvas id="canv1" height="50" width="50"><span id="siz1"></span></canvas>
            </div>
        </div>
    </div>
</div>
<div class="div">

</div>
<div class="col-12 mb-2">
    <div class="panel-admin-box">
        <div class="panel-admin-header">
            <div class="d-flex gap-5 ">
                <div class="new-buyers panel-header-gary panel-active">
                    <svg class="text-light" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 512">
                        <path d="M181.4 160c-11.88 0-21.38 9.625-21.38 21.38v85.25c0 11.75 9.625 21.38 21.38 21.38h85.25c11.75 0 21.38-9.5 21.38-21.38V181.4c0-11.88-9.625-21.38-21.38-21.38H181.4zM255.1 256h-64v-64h64V256zM340.7 107.3c6.477-6.479 6.186-17.07-.6406-23.18L250.5 4.031c-6-5.25-15-5.25-21 0l-224 196c-6.625 5.875-7.375 15.88-1.5 22.62c5.75 6.625 15.88 7.25 22.5 1.5l37.5-32.88l.0098 176.7c0 26.51 21.49 48 48 48l176.1 .0156C296.9 416 304 408.9 304 400.1s-7.146-16.04-15.96-16.04H111.1c-8.836 0-16-7.162-15.1-16L96 163.4l143.1-126.1l78.73 70.66C325 113.6 334.7 113.3 340.7 107.3zM424 112C454.9 112 480 86.88 480 56S454.9 0 424 0s-56 25.12-56 56S393.1 112 424 112zM424 32c13.23 0 24 10.77 24 24s-10.77 24-24 24s-24-10.77-24-24S410.8 32 424 32zM634.6 484.1l-69.75-62.19l-21.87-59.41c-3.078-8.297-12.27-12.52-20.55-9.484c-8.297 3.062-12.53 12.25-9.484 20.55l23.27 63.16c.9062 2.469 2.406 4.672 4.375 6.406l72.73 64.84C616.4 510.7 620.2 512 623.1 512c4.391 0 8.781-1.812 11.94-5.359C641.8 500 641.2 489.9 634.6 484.1zM533.7 244.6L513.5 164.1c5.244 .9121 10.48 1.975 15.45 3.963l26.72 10.69c14.27 5.703 25.02 18.02 28.75 32.92l8.062 32.25c2.156 8.578 10.89 13.72 19.39 11.64c8.578-2.141 13.8-10.83 11.64-19.39l-8.062-32.25c-6.203-24.86-24.11-45.38-47.91-54.89l-26.72-10.69c-17.56-7.016-36.72-9.312-55.5-6.656l-46.37 6.625c-31.33 4.469-54.95 31.72-54.95 63.36V232l-57.59 43.2C319.3 280.5 317.9 290.5 323.2 297.6C326.3 301.8 331.1 304 336 304c3.344 0 6.703-1.047 9.578-3.203l63.1-48C413.6 249.8 416 245 416 240V201.6c0-15.83 11.81-29.44 27.48-31.67l37.19-5.312l21.93 87.7c4.484 18.02-1.922 37.22-16.33 48.92l-79.11 64.23c-8.375 6.781-14.28 16.33-16.62 26.88l-22.17 100.2c-1.906 8.625 3.531 17.17 12.17 19.08C381.7 511.9 382.9 512 384 512c7.344 0 13.95-5.078 15.61-12.55l22.17-100.2c.7813-3.5 2.734-6.688 5.531-8.953l79.12-64.23C530.5 306.6 541.1 274.6 533.7 244.6z" />
                    </svg>
                    <span>{{ l('خریداران مرتبط') }}</span>
                </div>
                <div class="new-estate panel-header-gary">
                    <svg class="text-light" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 576 512">
                        <path d="M575.1 256c0-4.435-1.831-8.84-5.423-12l-58.6-51.87c.002-.0938 0 .0938 0 0l.0247-144.1c0-8.844-7.156-15.1-15.1-15.1l-95.1 .0074c-8.844 0-15.1 7.156-15.1 15.1L383.1 79.37l-85.42-75.37c-3.016-2.656-6.797-3.997-10.58-3.997c-3.781 0-7.563 1.341-10.58 3.997L5.423 244C1.831 247.2 .0005 251.6 .0005 256c0 8.924 7.241 15.99 16.05 15.99c3.758 0 7.521-1.313 10.53-3.993l37.42-33.02v197c0 44.12 35.89 79.1 79.1 79.1h287.1c44.11 0 79.1-35.87 79.1-79.1V234.1L549.4 268c3.031 2.688 6.812 3.1 10.58 3.1C568.7 271.1 575.1 264.9 575.1 256zM415.1 64h63.1v100.1l-63.1-56.47V64zM479.1 208v223.1c0 26.47-21.53 47.1-47.1 47.1H144c-26.47 0-47.1-21.53-47.1-47.1V208c0-.377-.1895-.6914-.2148-1.062L288 37.34l192.2 169.6C480.2 207.3 479.1 207.6 479.1 208zM208.4 218.6v106.7c0 14.62 11.1 26.62 26.62 26.62h106.6c14.75 0 26.75-12 26.75-26.62V218.6c0-14.62-11.1-26.62-26.75-26.62H235C220.4 192 208.4 204 208.4 218.6zM240.4 224h95.1v95.1H240.4V224z" />
                    </svg>
                    <span>{{ l('املاک مرتبط') }}</span>
                </div>
            </div>
            <div class="panel-header-left d-none d-md-block">
                <a class="panel-link-more new-buyers-content" href="#">{{ l('مشاهده همه خریداران جدید') }}
                    <i class="fal fa-chevron-left"></i>
                </a>
                <a class="panel-link-more new-estate-content d-none" href="#">{{ l('مشاهده همه املاک جدید') }}
                    <i class="fal fa-chevron-left"></i>
                </a>
            </div>
        </div>

        {{----}}
        <div class="d-block d-md-none">
            <a class="panel-link-more2 new-buyers-content" href="#">{{ l('مشاهده همه خریداران جدید') }}
                <i class="fal fa-chevron-left icon-left"></i>
            </a>
            <a class="panel-link-more2 new-estate-content d-none" href="#">{{ l('مشاهده همه املاک جدید') }}
                <i class="fal fa-chevron-left icon-left"></i>
            </a>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

<input type="hidden" name="activity_estate_type" id="activity_estate_type" />
<div class="modal fade" id="exampleModalPreview3" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel12" style="z-index: 99999; top: 0%; height: auto; bottom: 0% !important" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width:100%">
                    <div style="width:100%" class="d-flex justify-content-between">
                        <h5 class="modal-title" id="exampleModalPreviewLabel">{{ l('نوع ملک') }}</h5>

                        <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div style="width:100%;clear:both" class="mt-2">
                        <input class="form-control" id="cityListSearch" style="background: #FFFFFF;
border: 0.961261px solid #A3A3A3;
box-sizing: border-box;
border-radius: 23.0703px;
" type="text" placeholder="{{ l('جستجو') }}">

                    </div>
                    <div style="width:100%;clear:both;height:300px;overflow-y:scroll;scrollbar-color: black gray;
  scrollbar-width: thin;" dir="ltr" class="mt-2">
                        <div style="width:100%;">
                            @foreach(estateTypes() as $key=>$val)
                            <div style="width:100%;clear:both">
                                <label class="container1" style="float:right;text-align:right;padding-right:35px">{{$val}} &nbsp;&nbsp;
                                    <input type="checkbox" value="{{$key}}" class="checkbuilding" val="{{$val}}" {{in_array($key , $currentUser->activity_estate_type)?'checked="checked"':''}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach

                            {{--

                        <div style="width:100%;clear:both">
                            <label class="container1" style="float:right;text-align:right;padding-right:35px">{{ l('آپارتمان &nbsp;&nbsp;') }}
                            <input type="checkbox"  value="1" class="checkbuilding" val=l("آپارتمان")>
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <div style="width:100%;clear:both">
                        <label class="container1" style="float:right;text-align:right;padding-right:35px">{{ l('ویلایی &nbsp;&nbsp;') }}
                        <input type="checkbox"  value="2" class="checkbuilding" val=l("ویلایی") >
                        <span class="checkmark"></span>
                        </label>
                        </div>
                        <div style="width:100%;clear:both">
                        <label class="container1" style="float:right;text-align:right;padding-right:35px">{{ l('مغازه &nbsp;&nbsp;') }}
                        <input type="checkbox"  value="3" class="checkbuilding" val=l("مغازه") >
                        <span class="checkmark"></span>
                        </label>
                        </div>
                        <div style="width:100%;clear:both">
                        <label class="container1" style="float:right;text-align:right;padding-right:35px">{{ l('زمین و باغ &nbsp;&nbsp;') }}
                        <input type="checkbox"  value="4" class="checkbuilding" val=l("زمین و باغ") >
                        <span class="checkmark"></span>
                        </label>
                        </div>
                        <div style="width:100%;clear:both">
                        <label class="container1" style="float:right;text-align:right;padding-right:35px">{{ l('صنعتی-تجاری &nbsp;&nbsp;') }}
                        <input type="checkbox"  value="5" class="checkbuilding" val=l("صنعتی-تجاری") >
                        <span class="checkmark"></span>
                        </label>
               </div>--}}
                        </div>
                    </div>
                    <div style="width:100%">
                        <div class="column p-2 w-100 d-flex justify-content-around">

                            <div class="text-center"><label id="buildingcount"></label>{{ l('مورد') }}</div>
                            <div class="text-white text-center " id="insertbuilding" style="background: #025EC6;border-radius: 24px;width:197px;height:47px;font-size:18px;padding-top:10px">{{ l('افزودن') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<style>
    #exampleModalPreview2::-webkit-scrollbar {
        width: 10px;
    }

    #exampleModalPreview2::-webkit-scrollbar-track {
        background-color: darkgrey;
    }

    #exampleModalPreview2::-webkit-scrollbar-thumb {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }
</style>
<div class="modal fade" id="exampleModalPreview2" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel12" style="z-index: 99999; top: 0%; height: auto; bottom: 0% !important" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width:100%">
                    <div style="width:100%" class="d-flex justify-content-between">
                        <h5 class="modal-title" id="exampleModalPreviewLabel">{{ l('انتخاب محل یا محل های فعالیت') }}</h5>
                        <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div style="width:100%;clear:both" class="mt-2">
                        <input class="form-control" id="cityListSearch" style="background: #FFFFFF;
border: 0.961261px solid #A3A3A3;
box-sizing: border-box;
border-radius: 23.0703px;
" type="text" placeholder="{{ l('جستجو') }}">

                    </div>


                    <div style="width:100%;clear:both;height:300px;overflow-y:scroll;scrollbar-color: black gray;
  scrollbar-width: thin;" id="district1" dir="ltr" class="mt-2">
                        <div style="width:100%;clear:both">


                            @foreach($districts as $district)

                            <div style="width:100%;clear:both">

                                <label class="container1" style="float:right;text-align:right;padding-right:35px">{{$district->name}} &nbsp;&nbsp;
                                    <input type="checkbox" value="{{$district->id}}" class="checkdistrict" val="{{$district->name}}" {{!empty($selectedDistricts[$district->id])?'checked=checked':""}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="width:100%">
                        <div class="column p-2 w-100 d-flex justify-content-around">

                            <div class="text-center"><label id="districtcount"></label>{{ l('مورد') }}</div>
                            <div id="createDistrict" class="text-white text-center" style="background: #025EC6;border-radius: 24px;width:197px;height:47px;font-size:18px;padding-top:10px">{{ l('افزودن') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function show() {
        if ($(".sell").hasClass('actived') && $(".buy").hasClass('actived'))
            $("#activity_type").val(3);
        else if ($(".sell").hasClass('actived'))
            $("#activity_type").val(1);
        else if ($(".buy").hasClass('actived'))
            $("#activity_type").val(2);

        var activity_estate_type = [];
        var district_type = "";
        $(".build1").each(function() {
            activity_estate_type += $(this).attr('id') + ",";
        });


        $("#activity_estate_type").val(activity_estate_type);
        //$("#activity_estate_type").val(activity_estate_type);
        $(".district1").each(function() {
            district_type += $(this).attr('id') + ",";
        });
        $("#district_id").val(district_type);
        //alert($("#activity_type").val());
    }
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;

    var $modal1 = $('#modal1');
    var image1 = document.getElementById('image1');
    var cropper1;

    $("#cancel").click(function() {
        $modal.modal('hide');
    });
    $("#cancel1").click(function() {
        $modal1.modal('hide');
    });
    $("body").on("change", ".image", function(e) {
        var fileName = document.getElementById("photo1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;

        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {

        } else {
            document.getElementById("photo1").value = "";
            return false;
        }
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $("body").on("change", ".profile_cover", function(e) {

        var fileName = document.getElementById("profile1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;

        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {

        } else {
            document.getElementById("profile1").value = "";
            return false;
        }



        var files = e.target.files;


        var done = function(url) {
            image1.src = url;
            $modal1.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    $modal1.on('shown.bs.modal', function() {

        cropper1 = new Cropper(image1, {
            aspectRatio: 12 / 3,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper1.destroy();
        cropper1 = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 250,
            height: 250,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                $('#preview').attr('src', base64data);
                $(".editprofile1").addClass('d-block').removeClass('d-none');
                $(".uploadprofile1").addClass('d-none').removeClass('d-block');
                $("#preview").addClass('d-block').removeClass('d-none');
                $(".images1").val(base64data);
                $modal.modal('hide');
                /*
            $.ajax({
                type: "POST",

                url: '/estates/get_fields1',
                data: {_token:$('#js_csrf_token').val(),image: base64data},
                error: function()
                {
                    alert(l("خطای دریافت اطلاعات از سرور!"));
                },success: function(data){
                    $modal.modal('hide');
                    alert("success upload image");
                }
              });*/
            }
        });
    });


    $("#crop1").click(function() {
        canvas1 = cropper1.getCroppedCanvas({
            width: 1280,
            height: 853,
        });

        canvas1.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $(".editprofile").addClass('d-block').removeClass('d-none');
                $(".uploadprofile").addClass('d-none').removeClass('d-block');
                $("#preview1").addClass('d-block').removeClass('d-none');
                $('#preview1').attr('src', base64data);
                //alert('adadadad');
                $(".images2").val(base64data);
                $modal1.modal('hide');
            }
        });
    });
    var flagdis = 0;

    function checkdistrict() {
        let i = 0;
        $('.checkdistrict').each(function() {
            if (this.checked) {
                i++;
                if (i == 10)
                    flagdis = 1;
                else
                    flagdis = 0;
            }
        });
        $("#districtcount").html(i);
    }

    function checkbuilding() {
        let i = 0;
        $('.checkbuilding').each(function() {
            if (this.checked) {
                i++;
            }
        });
        $("#buildingcount").html(i);
    }
    $(document).ready(function() {
        $(".checkdistrict").change(function() {
            checkdistrict();
        });
        $(".checkbuilding").change(function() {
            checkbuilding();
        });



        if ('{{$currentUser->photo()}}'.length > 0) {
            $(".uploadprofile1").removeClass('d-block').addClass('d-none');
            $(".editprofile1").removeClass('d-none').addClass('d-block');

        } else {
            $(".editprofile1").removeClass('d-block').addClass('d-none');
            $(".uploadprofile1").removeClass('d-none').addClass('d-block');
        }

        if ('{{$currentUser->cover()}}'.length > 0) {
            $(".uploadprofile").removeClass('d-block').addClass('d-none');
            $(".editprofile").removeClass('d-none').addClass('d-block');
        } else {
            $(".editprofile").removeClass('d-block').addClass('d-none');
            $(".uploadprofile").removeClass('d-none').addClass('d-block');
        }



        $("#preview").mouseover(function() {
            if ($(this).attr('src')) {
                $(".gradiantover").addClass('d-block').removeClass('d-none');
                $(".card1").addClass('borderred').removeClass('borderblack');
            }
        });
        $("#preview1").mouseover(function() {
            if ($(this).attr('src')) {
                $(".gradiantover1").addClass('d-block').removeClass('d-none');
                $(".card2").addClass('borderred').removeClass('borderblack');
            }
        });
        $(".gradiantover").mouseout(function() {
            $(".gradiantover").addClass('d-none').removeClass('d-block');
            $(".card1").removeClass('borderred').addClass('borderblack');
        });
        $(".gradiantover1").mouseout(function() {
            $(".gradiantover1").addClass('d-none').removeClass('d-block');
            $(".card2").removeClass('borderred').addClass('borderblack');
        });

        $(".delprofile").on("click", function() {
            $(".photo").val(1);
            $("#preview").attr('src', '');
            $("#preview").addClass('d-none').removeClass('d-block');
            $(".images1").val('');
            $(".uploadprofile1").addClass('d-block').removeClass('d-none');
            $(".editprofile1").addClass('d-none').removeClass('d-block');
            $(".gradiantover").addClass('d-none').removeClass('d-block');
        });

        $(".delprofilecover").on("click", function() {
            $(".profile_cover1").val(1);
            $("#preview1").attr('src', '');
            $("#preview1").addClass('d-none').removeClass('d-block');
            $(".images2").val('');
            $(".uploadprofile").addClass('d-block').removeClass('d-none');
            $(".editprofile").addClass('d-none').removeClass('d-block');
            $(".gradiantover1").addClass('d-none').removeClass('d-block');
        });

        $(".actionclick").click(function() {
            if ($(this).hasClass('deactive')) {
                /*if($(this).hasClass('buy'))
                {
                    $('.sell').addClass('deactive').removeClass('actived');
                    $('.buy').addClass('actived').removeClass('deactive');
                }
                else
                {
                    $('.buy').addClass('deactive').removeClass('actived');
                    $('.sell').addClass('actived').removeClass('deactive');
                }*/
                $(this).addClass('actived').removeClass('deactive');

            } else {
                $(this).addClass('deactive').removeClass('actived');
            }

        });
        $('.monthly-performance').removeClass('d-block');
        $('.goals-performance').addClass('d-block');

        //$(".goals-performance").removeClass('d-block').addClass('d-none');


        $('.dashboard-top-mob').owlCarousel({
            rtl: true,
            items: 2,
            loop: false,
            dots: false,
            nav: false,
            margin: 10,
            autoWidth: true,
            // responsive: {
            //     0: {
            //         items: 1
            //     },
            //     600: {
            //         items: 1
            //     },
            //     1000: {
            //         items: 2
            //     }
            // }
        })
        $('.activity-mob').owlCarousel({
            rtl: true,
            items: 2,
            loop: false,
            dots: false,
            nav: false,
            margin: 1,
            autoWidth: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 2
                }
            }
        })

        $('.owl-carousel').owlCarousel({
            rtl: true,
            items: 2,
            loop: false,
            dots: false,
            nav: true,
            margin: 1,
            autoWidth: true,
            navText: ["<i class='fal fa-angle-right'></i>", "<i class='fal fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 2
                }
            }
        })
    })
    // $('form').focusin(function(){
    //     $(this).css('border-color', '#FA896B')
    //     // alert('in')
    // })
    // $('form').focusout(function(){
    //     $(this).css('border-color', '#E7E7E7')
    // })

    $(".plus1").click(function() {
        checkdistrict();
        $('#exampleModalPreview2').modal('show');
    });
    $(".plus2").click(function() {
        checkbuilding();
        $('#exampleModalPreview3').modal('show');
    });

    $(".close").click(function() {
        $('#exampleModalPreview2').modal('hide');
        $('#exampleModalPreview3').modal('hide');
    });

    $('.panel-form-input').on("keyup focus", function() {
        $(this).parent().css('border-color', '#FA896B')
        let inputValue = $(this).val();
        if (inputValue != 0) {
            $(this).next().next().prop('disabled', false)
        } else {
            $(this).next().next().prop('disabled', true)
        }
    })
    $('.panel-form-input').on("blur", function() {
        $(this).parent().css('border-color', '#E7E7E7')
    })
    if ($('.panel-form-input').val() == '') {
        $('.btn-panel').prop('disabled', true)
    } else {
        $('.btn-panel').prop('disabled', false)
    }
    $('.fa-plus').click(function() {
        if (parseInt($("#visit").val()) <= 10) {
            if (Math.round(parseInt($("#visit").val()) / parseInt(20 * 100) < 100)) {
                $("#visit").val(parseInt($("#visit").val()) + 1);
                PerformanceVisitUpdate($("#visit").val(), 0);
                $("#visit1").html($("#visit").val());
                $("#progressvisit").width(parseInt($("#visit").val()) / parseInt(20) * 100 + "%");

                $("#visitpercent").html(Math.round(10) / parseInt(2) * 100 + "%");

            }
        }
    });
    $('.fa-minus').click(function() {
        if (parseInt($("#visit").val()) >= 0) {
            $("#visit").val(parseInt($("#visit").val()) - 1);
            PerformanceVisitUpdate($("#visit").val(), 0);
            $("#visit1").html($("#visit").val());
            $("#progressvisit").width(parseInt(10) / parseInt(2) * 100 + "%");
            $("#visitpercent").html(Math.round(parseInt(10)) / parseInt(20) * 100 + "%")
        }
    });



    $('.new-buyers').click(function() {
        $('.new-buyers-content').removeClass('d-none')
        $('.new-estate-content').addClass('d-none')
    })

    $('.new-estate').click(function() {
        $('.new-buyers-content').addClass('d-none')
        $('.new-estate-content').removeClass('d-none')
    })


    $('.monthly-performance-edit').click(function() {
        $('.monthly-performance').addClass('d-none');
        $('.goals-performance').removeClass('d-none')
    })
    $('#income-target').click(function() {
        $('.monthly-income').removeClass('d-none');
        $('.goals-income').addClass('d-none')
    })
    $('.monthly-income-edit').click(function() {
        $('.monthly-income').addClass('d-none');
        $('.goals-income').removeClass('d-none')
    })
    $('.panel-header-gary').click(function() {
        $('.panel-header-gary').removeClass('panel-active')
        $(this).addClass('panel-active')
    })


    var errorcount = 0;

    function district() {

        var i = 0;
        var str = "";
        $('.checkdistrict').each(function() {
            if (this.checked) {

                i++;

                str += '<div class="district1 d-flex justify-content-center dcircle1 border_025EC6 " id="' + $(this).attr('value') + '" style="height:48px;padding-right:15px;padding-left:15px;" title="' + $(this).attr('val') + '">' +
                    '<i class="fa fa-times float-right pml_5 color_FF7373 districtdelele" id="districtdelele" style="font-weight: 1;font-size: 25px;" aria-hidden="true"></i>' +
                    '<span class="dcirlecontent2 color_5C5C5C">' +
                    $(this).attr('val') + '</span>' +
                    '</div>';
            }
        });
        if (i >= 10 && checkcr == 1) { alert('تعداد باید کمتر از 10 مورد باشد'); } else { $("#districtaction").html(str); } } function building() { var str = ""; $('.checkbuilding').each(function() { if (this.checked) { str += '<div class="build1 showtype d-flex justify-content-center dcircle2 border_025EC6" id="' + $(this).attr('value') + '" style=" width:140px;height:48px" title="{{ l('ویلایی') }}">' +
                    '<i class="fa fa-times float-right pml_5 color_FF7373 buildingdelete" style="font-weight: 1;font-size: 25px;" aria-hidden="true"></i>' +
                    '<span class="dcirlecontent1 color_5C5C5C">' +
                    $(this).attr('val') +
                    '</span>' +
                    '</div>';

            }

        });
        $("#buildingaction").html(str);
    }
    var checkcr = 0;
    $(document).ready(function() {
        district();
        building();
        $("#createDistrict").click(function() {
            checkcr = 1;
            district();
        });

        $("#insertbuilding").click(function() {
            building();
        });


        'use strict';
        $(function() {
            var todoListItem = $('.todo-list');
            var todoListInput = $('.todo-list-input');

            $('.todo-list-add-btn').on("click", function(event) {
                event.preventDefault();

                var item = $(this).prevAll('.todo-list-input').val();

                if (item) {

                    todoListItem.append("<li class='todo-list-item'><div class='form-check'><label class='form-check-label'><input class='checkbox' type='checkbox' />" + item + "<i class='input-helper'></i></label></div><i class='remove mdi mdi-close-circle-outline'></i></li>");
                    todoListInput.val("");
                }

            });
            $('.todo-list-input').on('keyup', function() {
                if ($(this).val() != 0) {
                    $(this).next().prop('disabled', false)
                } else {
                    $(this).next().prop('disabled', true)
                }
            })

            todoListItem.on('change', '.checkbox', function() {
                if ($(this).attr('checked')) {
                    $(this).removeAttr('checked');
                } else {
                    $(this).attr('checked', 'checked');
                }

                $(this).closest("li").toggleClass('completed');

            });

            todoListItem.on('click', '.remove', function() {
                $(this).parent().remove();
            });

        });
    })




    var inlag = 0;

    function PerformanceVisitUpdate(visit, contract_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/dashboard/PerformanceVisitUpdate',
            type: "POST",
            data: {
                visit: visit,
                contract_id: contract_id
            },
            success: function(data) {

            }
        });
    }

    function sendcontracts(contract_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/dashboard/performanceCreate',
            type: "POST",
            data: {
                contract: contract_id
            },
            success: function(data) {
                if (data.status == 1) {
                    toast({
                        type: 'success',
                        title: l('گزینه ی مورد نظر با موفقیت ثبت شد.')
                    });
                }
            }
        });
    }
    $(document).on("click", ".districtdelele", function() {
        $(this).parent().remove();
    });
    $(document).on("click", ".buildingdelete", function() {
        $(this).parent().remove();
    });
    $(document).ready(function() {


        $(document).scroll(function() {
            inlag = 1;
            var dg = parseInt(parseInt($(window).scrollTop()) / parseInt($(document).height()) * 360);
            var dg2 = parseInt($(window).scrollTop()) / (parseInt($(document).height()) - parseInt($(window).height())) * 100;

            //$("#siz1").html($(window).scrollTop()+parseInt($(window).height());
            if (dg2 == 0)
                update(1);
            else
                update(dg2);
            //$('.RotateBorder').css('background-image', 'linear-gradient('+dg+'deg, transparent 50%, rgb(108, 52, 203) 50%), linear-gradient(90deg, rgb(255, 255, 255) 50%, transparent 50%)');
            //alert(dg);
        });
        if (inlag == 0);

    });

</script>

@include('frontend.layouts.footer1',['cssClass'=>'intro'])
@endsection
