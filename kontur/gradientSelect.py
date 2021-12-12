from __future__ import print_function
import cv2 as cv
import numpy as np
import base64
import random
import string
import os
import requests

good_images = [];

morph_size = 0
max_operator = 2
max_elem = 2
max_kernel_size = 100
title_trackbar_operator_type = 'Operator:\n 0: Opening - 1: Closing  \n 2: Gradient - 3: Top Hat \n 4: Black Hat'
title_trackbar_element_type = 'Element:\n 0: Rect - 1: Cross - 2: Ellipse'
title_trackbar_kernel_size = 'Kernel size:\n 2n + 1'
trackbar_value = "Threshold"
title_window = 'Morphology Transformations Demo'
morph_op_dic = {0: cv.MORPH_GRADIENT, 1: cv.MORPH_TOPHAT, 2: cv.MORPH_BLACKHAT}


def get_random_string(length):
	# choose from all lowercase letter
	letters = string.ascii_lowercase
	result_str = ''.join(random.choice(letters) for i in range(length))
	return result_str

def writeImg(img,path):
	cv.imwrite(path,img)


def alphaBlendSrc2Dst(pathImg,pathMask):
	img = cv.imread(pathImg)
	mask = cv.imread(pathMask)
	newShape = [min(img.shape[0],mask.shape[0]),min(img.shape[1],mask.shape[1])];

	img = cv.resize(img,(newShape[1],newShape[0]))
	mask = cv.resize(mask, (newShape[1], newShape[0]))
	# img = img[0:newShape[0],0:newShape[1]]
	# mask = mask[0:newShape[0],0:newShape[1]]
	mask = 255 - mask
	blured = np.full(img.shape,255.0)
	# blured = cv.GaussianBlur(img, (19, 19), 11)

	mask = cv.GaussianBlur(mask, (19, 19), 11)
	# cv.invert(img,img)
	if mask.ndim == 3 and mask.shape[-1] == 3:
		alpha = mask/255.0
	else:
		alpha = cv.cvtColor(mask, cv.COLOR_GRAY2RGB)/255.0
	blended = cv.convertScaleAbs(img*(1-alpha) + blured*alpha)
	return blended

def alphaBlend(img):
	H,W = img.shape[:2]
	mask = np.zeros((int(H),int(W)), np.uint8)
	mask = cv.circle(mask, (int(W/2),int(H/2)), int(H/2.5), (255,255,255), -1, cv.LINE_AA)
	mask = 255 - mask
	mask = cv.GaussianBlur(mask, (21,21), 11)

	blured = cv.GaussianBlur(img, (21,21), 11)

	if mask.ndim==3 and mask.shape[-1] == 3:
		alpha = mask/255.0
	else:
		alpha = cv.cvtColor(mask, cv.COLOR_GRAY2BGR)/255.0
	blended = cv.convertScaleAbs(img*(1-alpha) + blured*alpha)
	return blended


def gradientSelect(urls, write=False,pathInternalFile=None):
	path = os.getcwd()+"/temp_grad/" + str(get_random_string(10)) + "."+urls[0].split(".")[-1]
	pathW = os.getcwd()+"/generated/" + str(get_random_string(10)) + "."+urls[0].split(".")[-1]
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

	cv.fastNlMeansDenoisingColored(src, src, 10, 14, 20, 20)

	morph_operator = 1
	morph_size = 14
	# threshold_value = cv.getTrackbarPos(trackbar_value, title_window)

	element = cv.getStructuringElement(cv.MORPH_ELLIPSE, (2*morph_size + 1, 2*morph_size+1), (morph_size, morph_size))
	# elementEclipseSmall = cv.getStructuringElement(cv.MORPH_ELLIPSE, (3, 3))
	operation = morph_op_dic[morph_operator]
	
	

	
	
	dst = alphaBlend(src)
	dst = cv.morphologyEx(dst, operation, element)
	# _, dst = cv.threshold(dst, threshold_value, 255, cv.THRESH_TRUNC )
	dst = cv.cvtColor(dst,cv.COLOR_RGB2GRAY)




	# dst = cv.medianBlur(dst,7)
	# dst2 = cv.morphologyEx(dst, morph_op_dic[0], elementEclipseSmall)
	if(write):
		print(pathW)
		cv.imwrite(pathW,dst)
	retval, buffer = cv.imencode('.jpg', dst)
	jpg_as_text = base64.b64encode(buffer).decode()
	print(jpg_as_text[0:100])
	return jpg_as_text
