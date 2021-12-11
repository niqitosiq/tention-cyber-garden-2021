import cv2 as cv

img = cv.imread("img.jpg")

gray_img = cv.cvtColor(img, cv.COLOR_BGR2GRAY)
# noise reduction
ret, thresh = cv.threshold(gray_img, 127, 255, 0)
# Looking for contours
contours, hierarchy = cv.findContours(gray_img, cv.RETR_TREE, cv.CHAIN_APPROX_NONE)

cnt = contours[0]

# epsilon is calculated according to the percentage of perimeter, taking 1% and 10% of perimeter respectively
epsilon_1 = 0.1 * cv.arcLength(cnt, True)
epsilon_2 = 0.01 * cv.arcLength(cnt, True)

# Polygonal approximation
approx_1 = cv.approxPolyDP(cnt, epsilon_1, True)
approx_2 = cv.approxPolyDP(cnt, epsilon_2, True)

# Draw a polygon
image_1 = cv.cvtColor(gray_img, cv.COLOR_GRAY2BGR)
image_2 = cv.cvtColor(gray_img, cv.COLOR_GRAY2BGR)

cv.polylines(image_1, [approx_1], True, (0, 0, 255), 2)
cv.polylines(image_2, [approx_2], True, (0, 0, 255), 2)

cv.imshow("image_1", image_1)
cv.imshow("image_2", image_2)
cv.waitKey(0)
cv.destroyAllWindows()