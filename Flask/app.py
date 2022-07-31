from flask import Flask,render_template
app = Flask(__name__)

@app.route('/')
def hello_world():
    mylist=[
        {"id":1,"name":"Lovely","age":20,"email":"lovelysingeras297@gmail.com"},
        {"id":2,"name":"Om","age":21,"email":"om@gmail.com"},
        {"id":3,"name":"Sahil","age":19,"email":"sahil@gmail.com"}
    ]
    return render_template('index.html',data=mylist)

if __name__=="__main__":
    app.run(debug=True)