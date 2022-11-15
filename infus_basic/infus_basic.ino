#include <ESP8266WiFi.h>
#include <ESP8266WiFi.h>
#include <Ticker.h>
#include <HX711_ADC.h>
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

Ticker blinker;

float tPerDrops;
float timeMillis;
unsigned long jumlahTetes = 0;
float oldtPerDrops;
float dropsPerMinutes;
float dropsPerSecond = 0;

const int LOADCELL_DOUT_PIN = D6;
const int LOADCELL_SCK_PIN = D7;

HX711_ADC LoadCell(LOADCELL_DOUT_PIN,LOADCELL_SCK_PIN);

void ICACHE_RAM_ATTR voidCounter ();

const char* ssid = "B45";
const char* password = "Asu123ok";

const char* host = "192.168.100.124";

void timerIsr() {
  blinker.detach();
  tPerDrops = timeMillis - oldtPerDrops;
  oldtPerDrops = timeMillis;
  if (tPerDrops > 100) {
    dropsPerMinutes = 1000 / tPerDrops * 60;
  }
  dropsPerSecond = 60/dropsPerMinutes;

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
  Serial.println();
  LoadCell.begin();
  LoadCell.start(2000);
  LoadCell.setCalFactor(114.308);
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
  timer();
  berat();
  Kirim();
  
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
    Serial.println(dropsPerMinutes, 1);
    display.display();
  }
}
unsigned long LTimer;
void Kirim(){
  WiFiClient client;
  unsigned long NTimer = millis();
  if (NTimer - LTimer > 60000){
    LTimer = NTimer;
    Serial.printf("\n[Connecting to %s ... ", host);
    if(dropsPerSecond > 0){
        if (client.connect(host, 8080))
        {
          Serial.println("connected]");
          String url = "/iot/public/sensor/"+String(dropsPerMinutes);
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
              Serial.println("200 OK");
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


void berat(){
  LoadCell.update();
  float i = LoadCell.getData();
  if(i<0){
    i=0;
  }
  Serial.print("Berat[g]: ");
  Serial.println(i);
}
