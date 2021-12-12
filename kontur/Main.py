from flask import Flask
from flask import request
import requests
from gradientSelect import gradientSelect, alphaBlendSrc2Dst, writeImg, get_random_string
from lightMap import lightMap
import requests
import os
import base64
import cv2 as cv

app = Flask(__name__)

def parseUrls(req):
	json = req.get_json(force=True)
	if(json == None or len(json) == 0):
		abort(500, "Wake up neo, u obosralsya")
	urls = []
	for cortege in json["sources"]["wordsImg"]:
		urls.append(cortege["url"])

	return(("{\"success\":true,\"img\":",urls))


@app.route("/api/getContour_lightMap", methods=['POST'])
def lightM():
	returnable, urls = parseUrls(request)
	# returnable += lightMap(urls)+"\"}"
	return lightMap(urls)


@app.route("/api/getContour_gradientSelect", methods=['POST'])
def gradientSel():
	returnable, urls = parseUrls(request)
	returnable += requests.utils.quote(gradientSelect(urls))+"\"}"
	return returnable


@app.route("/api/generate", methods=['POST'])
def generatePicture():
	returnable, urls = parseUrls(request)
	path = os.getcwd()+"/temp_gen/"+str(get_random_string(10)) + "." + urls[0].split(".")[-1]
	
	r = requests.get(urls[0], stream=True)
	if r.status_code == 200:
		with open(path, 'wb') as f:
			for chunk in r:
				f.write(chunk)
	
	
	files = {"file": open(path, 'rb')}
	p = requests.post("http://192.168.43.237:8501/neuro",files=files)


	# return "ahahahhaloh"
	base64EncodedNeuro = p.content

	imgdata = base64.b64decode(base64EncodedNeuro)
	# return base64EncodedNeuro
	neuralImgPath = os.getcwd()+str(get_random_string(10)) + '.jpg'
	with open(neuralImgPath, 'wb') as f:
		f.write(imgdata)

	jpgAsTextN,lightMapWritten =  lightMap(urls,write=True)


	rawImageGenerated = alphaBlendSrc2Dst(neuralImgPath,lightMapWritten)
	
	os.remove(path)
	os.remove(neuralImgPath)

	retval, buffer = cv.imencode('.jpg', rawImageGenerated)
	jpg_as_text = base64.b64encode(buffer).decode()
	return (jpg_as_text)



if __name__ == "__main__":
	# writeImg(alphaBlendSrc2Dst("./img8.jpeg",
	# 		 "./generated/fysqmkbdpn.jpg"), "./testing3.jpg")
	

	# gradientSelect(["a.jpg"],True,"./img.jpg")
	# gradientSelect(["a.jpg"], True, "./img2.jpg")
	# gradientSelect(["a.jpg"], True, "./img3.jpg")
	# gradientSelect(["a.png"], True, "./img4.png")
	# gradientSelect(["a.jpg"], True, "./img6.jpg")

	# lightMap(["a.jpg"], True, "./img.jpg")
	# lightMap(["a.jpg"], True, "./img2.jpg")
	# lightMap(["a.jpg"], True, "./img3.jpg")
	# lightMap(["a.png"], True, "./img4.png")
	# lightMap(["a.jpg"], True, "./img8.jpg")
	# lightMap(["a.jpg"], True, "./img9.jpg")
	# lightMap(["a.jpg"], True, "./img10.jpg")
	app.run(host='0.0.0.0', port=3001)
