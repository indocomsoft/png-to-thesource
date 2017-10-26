# png-to-thesource

A quick and dirty script in PHP that I wrote for my [CS1101S module](http://github.com/indocomsoft/CS1101S-indocomsoft) 2D and 3D contest (Contests 2.2 and 3.2).

This script takes in a png file as an input. It applies Floyd-Steinberg dithering to turn the picture into indexed colour mode of 11 colour pallete available in the source 2d_rune and 3d_rune libraries. It then generates source code required to output that image. So in a way, this is a transpiler from png to The Source.