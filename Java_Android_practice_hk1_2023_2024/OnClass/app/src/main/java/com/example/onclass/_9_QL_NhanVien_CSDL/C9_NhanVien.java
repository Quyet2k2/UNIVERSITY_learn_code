package com.example.onclass._9_QL_NhanVien_CSDL;

public class C9_NhanVien {
    private int id;
    private String Name;
    private int GioiTinh, Check;

    public C9_NhanVien(int id, String name, int gioiTinh, int check) {
        this.id = id;
        Name = name;
        GioiTinh = gioiTinh;
        Check = check;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public int getGioiTinh() {
        return GioiTinh;
    }

    public void setGioiTinh(int gioiTinh) {
        GioiTinh = gioiTinh;
    }

    public int getCheck() {
        return Check;
    }

    public void setCheck(int check) {
        Check = check;
    }
}
