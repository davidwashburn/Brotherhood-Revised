// Created by Dwavid on 9.19.16

// Main Page Visual Javascript [JQERY]

$( document ).ready(function() {
    //Open Main Menu and activate dimmer
    $('#navMenu').click('click', function (){
        $('#mainMenu').toggleClass("active");
        $('#settingsMenu').toggleClass("active");
        $('#overlay').toggleClass("active");
        $('#body').toggleClass("hideOverFlow");
    });
    $('#menuCloseButton').click('click', function (){
        $('#mainMenu').toggleClass("active");
        $('#overlay').toggleClass("active");
        $('#body').toggleClass("hideOverFlow");
    });
    //Click off Menu to close
    $('#overlay').click('click', function (){
        $('#mainMenu').removeClass("active push");
        $('#settingsMenu').removeClass("active push");
        $('#overlay').toggleClass("active");
        $('#body').toggleClass("hideOverFlow");
    });
    //Settings Menu Open and Close
    $('#settingsMenuButton').click('click', function (){
        $('#settingsMenu').addClass("push");
        $('#mainMenu').addClass("push");
    });
    $('#settingsCloseButton').click('click', function (){
        $('#settingsMenu').removeClass("push");
        $('#mainMenu').removeClass("push");
    });

    // Show/Hide Sections using slideToggle
    $('#navSearch').click('click', function (){
        $('#navHeaderMenu').slideToggle("fast");
    });
    $('#indexStory').click('click', function (){
        $('#indexStoryContent').slideToggle("fast");
        $('#indexStoryHero').slideToggle("fast");
    });
    $('#indexRoster').click('click', function (){
        $('#indexRosterContent').slideToggle("fast");
        $('#indexRosterHero').slideToggle("fast");
    });
    $('#indexAbout').click('click', function (){
        $('#indexAboutContent').slideToggle("fast");
        $('#indexAboutHero').slideToggle("fast");
    });

});

