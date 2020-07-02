# MyBB_Plugin-TopPosterToday

* Top Posters Today
*
* Authors: GiboneKPL & Vintagedaddyo 
* 
* MyBB Version: 1.8 
* 
* Plugin Version: 1.0.1

Current localization support:


- english * completed
- englishgb * completed
- espanol * completed
- french * completed
- italiano * completed

~ Vintagedaddyo


 Installation:

 1. Transfer the files from /Upload/ directory to your MyBB Root directory
 
 2. Go to ACP -> Configuration -> Plugins and activate the plugin
 
 3. Go to ACP -> Configuration -> Top shouters -> And set how many users to show.
 
* #4 & #5 optional as the template insert them but you can choose to move them around

 4. Go to ACP -> Styles and templates -> Templates -> Your_Template -> Home -> index -> Insert variable {$tptindex} where you want.

 5. Go to ACP -> Styles and templates -> Templates -> Your_Template -> Home -> portal -> Insert variable {$tptportal} where you want.
 

* only needed if say your additional theme doesn't have this already

 6. Go to ACP -> Styles and Templates -> Your_Style -> Global.css -> And insert at the end:
 
 #top_posters li {
 text-align: center;
 padding: 8px 0 0 0;
 margin: 5px 0 0 0;
 min-width: 80px;
 height: 80px;
 float: left;
         font-size: 0.80em;
 }

 .list_content {
 word-wrap: break-word;
 }

 .avatar
  margin-left: 8px;
  margin-top: 1px;
  margin-bottom: 1px;
  float: left;
 }
 
 7. Save and enjoy the plugin!


 Change of appearance:
 
 1. Go to ACP -> Styles and Templates -> Templates -> Global Templates
 
 2. Edit the templates: tpt and tpt_row
 
 3. Go to ACP -> Styles and Templates -> Your_Style -> Global.css
 
 4. Edit classes and IDs: #top_posters_li, .list_content, .avatar