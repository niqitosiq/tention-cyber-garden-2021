from __future__ import print_function
import cv2 as cv
import numpy as np
import argparse

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


def alphaBlend(img):
	H,W = img.shape[:2]
	mask = np.zeros((int(H),int(W)), np.uint8)
	mask = cv.circle(mask, (int(W/2),int(H/2)), int(H/2.5), (255,255,255), -1, cv.LINE_AA)
	mask = 255 - mask
	mask = cv.GaussianBlur(mask, (51,51), 11)

	blured = cv.GaussianBlur(img, (21,21), 11)

	if mask.ndim==3 and mask.shape[-1] == 3:
		alpha = mask/255.0
	else:
		alpha = cv.cvtColor(mask, cv.COLOR_GRAY2BGR)/255.0
	blended = cv.convertScaleAbs(img*(1-alpha) + blured*alpha)
	return blended

def morphology_operations(val):
	morph_operator = cv.getTrackbarPos(title_trackbar_operator_type, title_window)
	morph_size = cv.getTrackbarPos(title_trackbar_kernel_size, title_window)
	threshold_value = cv.getTrackbarPos(trackbar_value, title_window)

	element = cv.getStructuringElement(cv.MORPH_ELLIPSE, (2*morph_size + 1, 2*morph_size+1), (morph_size, morph_size))
	elementEclipseSmall = cv.getStructuringElement(cv.MORPH_ELLIPSE, (3, 3))
	operation = morph_op_dic[morph_operator]
	
	

	
	
	dst = alphaBlend(src)
	dst = cv.morphologyEx(src, operation, element)
	_, dst = cv.threshold(dst, threshold_value, 255, cv.THRESH_TRUNC )
	dst = cv.cvtColor(dst,cv.COLOR_RGB2GRAY)




	# dst = cv.medianBlur(dst,7)
	# dst2 = cv.morphologyEx(dst, morph_op_dic[0], elementEclipseSmall)
	cv.imshow(title_window, dst)


src = cv.imread("img.jpg")

# cv.fastNlMeansDenoisingColored(src,src, 10, 20, 40, 40)
# src	Input 8-bit 3-channel image.
# dst	Output image with the same size and type as src .
# templateWindowSize	Size in pixels of the template patch that is used to compute weights. Should be odd. Recommended value 7 pixels
# searchWindowSize	Size in pixels of the window that is used to compute weighted average for given pixel. Should be odd. Affect performance linearly: greater searchWindowsSize - greater denoising time. Recommended value 21 pixels
# h	Parameter regulating filter strength for luminance component. Bigger h value perfectly removes noise but also removes image details, smaller h value preserves details but also preserves some noise
# hColor	The same as h but for color components. For most images value equals 10 will be enough to remove colored noise and do not distort colors


cv.namedWindow(title_window)
cv.createTrackbar(title_trackbar_operator_type, title_window , 0, max_operator, morphology_operations)
cv.createTrackbar(title_trackbar_kernel_size, title_window , 0, max_kernel_size, morphology_operations)
cv.createTrackbar(trackbar_value, title_window , 0, 255, morphology_operations)
morphology_operations(0)
cv.waitKey()