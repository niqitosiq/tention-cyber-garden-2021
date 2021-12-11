from __future__ import print_function
import cv2 as cv
import argparse
import numpy as np
import math
import time

max_value = 255
max_type = 4
max_binary_value = 255
trackbar_type = 'Type: \n 0: Binary \n 1: Binary Inverted \n 2: Truncate \n 3: To Zero \n 4: To Zero Inverted'
trackbar_value = 'Value'
window_name = 'Threshold Demo'


src = cv.imread('img3.jpg')
src = cv.resize(src, (0, 0), fx=0.5, fy=0.5)
src_gray = cv.cvtColor(src, cv.COLOR_RGB2GRAY)
just_white = np.zeros((src.shape[:2][0], src.shape[:2][1], 3), np.uint8)

cv.namedWindow(window_name)
# Create Trackbar to choose Threshold value

divider = 40
array_of_contours = []
for i in range(math.floor(255/divider)):
	threshold_type = 1
	threshold_value = i*divider
	print(threshold_value)
	_, dst = cv.threshold(src_gray, threshold_value, max_binary_value, threshold_type )

	
	contours, hierarchy = cv.findContours(
		dst, cv.RETR_TREE, cv.CHAIN_APPROX_NONE)
	sorted_list = list(sorted(contours, key=len))
	# sorted_list = sorted_list[int(sortedlen*0.95):(sortedlen-1 if sortedlen!=0 else sortedlen)]
	# sorted_list = [s for s in sorted_list if len(s)>400]
	sorted_list = [s for s in sorted_list if cv.contourArea(s)>500]
	sortedlen = len(sorted_list)
	jumpof_num = 5
	flatten_filtered_contours = np.array([len(sorted_list)])
	for contour in sorted_list:
		contour_length = contour.shape[0]
		if(contour_length > jumpof_num+1):
			flatten_contour = np.array(contour.shape)
			for j in range(contour_length):
				if(j+jumpof_num >= contour_length):
					break
				contour[j][0][0] += (contour[j+jumpof_num][0][0] - contour[j][0][0])/2
				contour[j][0][1] += (contour[j+jumpof_num][0][1] - contour[j][0][1])/2
		


	array_of_contours.append(sorted_list)
for counters in array_of_contours:
	cv.drawContours(just_white, counters, -1, (255, 255, 255), 1)
	cv.imshow(window_name, just_white)
im = cv.cvtColor(just_white, cv.COLOR_BGR2GRAY)
# if you plot im now you will see grey contours not white
im[im!=0]=255

cv.imshow(window_name, just_white)

# Wait until user finishes program
cv.waitKey()