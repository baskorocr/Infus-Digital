#include <ESP8266WiFi.h>
#include <ESP8266WiFi.h>
#include <Ticker.h>
#include "HX711.h"
#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 64 // OLED display height, in pixels
// Declaration for SSD1306 display connected using I2C
#define OLED_RESET     -1 // Reset pin # (or -1 if sharing Arduino reset pin)
#define SCREEN_ADDRESS 0x3C 
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);
#define DOUT  D6
#define CLK  D7

Ticker blinker;

float tPerDrops;
float timeMillis;
unsigned long jumlahTetes = 0;
float oldtPerDrops;
float dropsPerMinutes;
float dropsPerSecond;
float kapasitas = 0;
String idAlat = "11111111";
String status = "";

HX711 scale(DOUT, CLK);
float calibration_factor = -238635;

void ICACHE_RAM_ATTR voidCounter ();


const char* ssid = "sync";
const char* password = "Asu123ok";

const char* host = "192.168.1.11";

void timerIsr() {
  blinker.detach();
  tPerDrops = timeMillis - oldtPerDrops;
  oldtPerDrops = timeMillis;
  if (tPerDrops > 100) {
    dropsPerMinutes = 1000 / tPerDrops * 60;
    dropsPerSecond = 60/dropsPerMinutes;
  }
  

    blinker.attach(0.1, timerIsr); 
}

void voidCounter() {
  timeMillis = millis();

}

void setupProses() {
  attachInterrupt(digitalPinToInterrupt(14), voidCounter, FALLING);
  blinker.attach(0.1, timerIsr); 
}

void setup()
{
  Serial.begin(115200);
 
  scale.set_scale();
  scale.tare(); //Reset the scale to 0
  long zero_factor = scale.read_average();

  Serial.println();
  pinMode(D3, INPUT_PULLUP);
  Serial.printf("Connecting to %s ", ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" connected");
  setupProses();
   if(!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS)) {
    Serial.println(F("SSD1306 allocation failed"));
    for(;;); // Don't proceed, loop forever
  }
}


void loop()
{
  int reset = digitalRead(D3);
  if(reset == 0){
    resetV();
  }
  else{
    berat();
    timer();
    Kirim();
  }

  
  
}

void resetV(){
  dropsPerSecond = 0;
  dropsPerMinutes = 0;

}


unsigned long oldTimer;
void timer() {

  unsigned long tTimer = millis();
  if (tTimer - oldTimer > 2000) {
    oldTimer = tTimer;
    display.clearDisplay();
    display.setTextSize(2);
    display.setTextColor(WHITE);
    display.setCursor(0,10);
    display.print("T/D :");
    display.println(dropsPerSecond);
    display.print("D/M :");
    display.println(dropsPerMinutes, 1);
    display.print("K :");
    display.println(kapasitas, 1);
 
    display.display();
  }
}

void berat(){
  scale.set_scale(calibration_factor);
  kapasitas = scale.get_units();
  kapasitas = kapasitas * 1000;  
  
  if(kapasitas <= 0 ){
    kapasitas = 0;
  }
  if(kapasitas <= 100){
    status = "LOW";
  }
  else{
    status = "HIGH";
  }

  

}

unsigned long LTimer;
void Kirim(){
  WiFiClient client;
  unsigned long NTimer = millis();
  if (NTimer - LTimer >  60000){
    LTimer = NTimer;
    Serial.printf("\n[Connecting to %s ... ", host);
    if(dropsPerSecond > 0){
        if (client.connect(host, 8080))
        {
          Serial.println("connected]");
          String url = "/iot/public/sensor/"+idAlat+"/"+String(dropsPerMinutes)+"/"+String(kapasitas)+"/"+status;
          Serial.println("[Sending a request]");
          client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                      "Host: " + host + "\r\n" +
                      "Connection: close\r\n" +
                      "\r\n"
                      );

          Serial.println("[Response:]");
          while (client.connected() || client.available())
          {
            if (client.available())
            {
              String line = client.readStringUntil('\n');
              Serial.println(line);
            }
          }
          client.stop();
          Serial.println("\n[Disconnected]");
        }
        else
        {
          Serial.println("connection failed!]");
          client.stop();
        }
    }
  }
}