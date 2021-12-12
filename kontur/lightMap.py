from __future__ import print_function
import cv2 as cv
import argparse
import numpy as np
import math
import time
import base64
import random
import string
import os
import requests


def get_random_string(length):
	# choose from all lowercase letter
	letters = string.ascii_lowercase
	result_str = ''.join(random.choice(letters) for i in range(length))
	return result_str


def lightMap(urls, write=False, pathInternalFile=None, rawImage = False):
	path = os.getcwd()+"/temp_map/"+str(get_random_string(10)) + "." + urls[0].split(".")[-1]
	pathW = os.getcwd()+"/generated/" + str(get_random_string(10)) + "." + urls[0].split(".")[-1]
	src = None
	if(pathInternalFile == None):
		r = requests.get(urls[0], stream=True)
		if r.status_code == 200:
			with open(path, 'wb') as f:
				for chunk in r:
					f.write(chunk)
		src = cv.imread(path)
	else:
		src = cv.imread(pathInternalFile)

	# src = cv.resize(src, (0, 0), fx=0.5, fy=0.5)
	src_gray = cv.cvtColor(src, cv.COLOR_RGB2GRAY)
	just_white = np.zeros((src.shape[:2][0], src.shape[:2][1], 3), np.uint8)


	divider = 30
	array_of_contours = []
	for i in range(math.floor(255/divider)):
		threshold_type = 1
		threshold_value = i*divider
		print(threshold_value)
		_, dst = cv.threshold(src_gray, threshold_value, 255, threshold_type )

		
		contours, hierarchy = cv.findContours(
			dst, cv.RETR_TREE, cv.CHAIN_APPROX_NONE)
		sorted_list = list(sorted(contours, key=len))
		# sorted_list = sorted_list[int(sortedlen*0.95):(sortedlen-1 if sortedlen!=0 else sortedlen)]
		# sorted_list = [s for s in sorted_list if len(s)>400]
		sorted_list = [s for s in sorted_list if cv.contourArea(s)>1200]
		sortedlen = len(sorted_list)
		jumpof_num = 10
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
		cv.drawContours(just_white, counters, -1, (255, 255, 255), 20)
	if(write):
		cv.imwrite(pathW, just_white)
	os.remove(path)
	retval, buffer = cv.imencode('.jpg', just_white)
	jpg_as_text = base64.b64encode(buffer).decode()
	return (jpg_as_text,pathW)



