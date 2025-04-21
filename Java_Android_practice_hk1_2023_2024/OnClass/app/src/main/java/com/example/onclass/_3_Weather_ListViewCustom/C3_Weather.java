package com.example.onclass._3_Weather_ListViewCustom;

public class C3_Weather {
    private String address;
    private String weather;
    private int c;
    private int image;

    public C3_Weather() {
    }

    public C3_Weather(String address, String weather, int c, int image) {
        this.address = address;
        this.weather = weather;
        this.c = c;
        this.image = image;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getWeather() {
        return weather;
    }

    public void setWeather(String weather) {
        this.weather = weather;
    }

    public int getC() {
        return c;
    }

    public void setC(int c) {
        this.c = c;
    }

    public int getImage() {
        return image;
    }

    public void setImage(int image) {
        this.image = image;
    }
}
