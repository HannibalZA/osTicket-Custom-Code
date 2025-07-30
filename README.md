# osTicket-Custom-Code

osTicket plugin that allows for inserting custom CSS and JS code to the client and staff interfaces.

![image](https://user-images.githubusercontent.com/2007626/211731476-9ea93a58-49bf-44d2-9790-a97befd08569.png)
![image](https://user-images.githubusercontent.com/2007626/211731517-b81acca0-0a27-496d-9820-1209ffcd306e.png)
![image](https://user-images.githubusercontent.com/2007626/211731556-4de65290-3412-4f2b-b252-43a547073210.png)


Disclaimer: This is not the ideal solution, but works well and is upgrade-proof without amending core files. 

Feel free to contribute improvements...

## Installation

You will need to convert to phar before uploading to /include/plugins directory.

1. Download the zip file
2. The initial plugin and config files need to be in the root of a zip file for phar processing. No subdirectory.
3. Upload to a phar converter tool such as: https://www.pustudy.com/online_tools/phar-converter/
4. Upload customcode.phar file as a normal plugin to /include/plugins directory
5. In Admin Panel > Manage > Plugins > Install
6. Add an "Instance"
7. Now you will see a "Config" tab to allow you to add CSS/JS to the client and staff areas
