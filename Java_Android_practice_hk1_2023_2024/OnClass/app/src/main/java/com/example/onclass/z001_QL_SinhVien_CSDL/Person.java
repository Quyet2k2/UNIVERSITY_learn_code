package com.example.onclass.z001_QL_SinhVien_CSDL;

import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

public class Person implements Parcelable {
    public static final Parcelable.Creator<Person> CREATOR = new Parcelable.Creator<Person>() {
        @Override
        public Person createFromParcel(Parcel in) {
            return new Person(in);
        }

        @Override
        public Person[] newArray(int size) {
            return new Person[size];
        }
    };
    private int id;
    private String name, ngaySinh, diaChi;
    private int gioiTinh;
    private String truongYeuThich;

    public Person(int id, String name, String ngaySinh, String diaChi, int gioiTinh, String truongYeuThich) {
        this.id = id;
        this.name = name;
        this.ngaySinh = ngaySinh;
        this.diaChi = diaChi;
        this.gioiTinh = gioiTinh;
        this.truongYeuThich = truongYeuThich;
    }

    protected Person(Parcel in) {
        id = in.readInt();
        name = in.readString();
        ngaySinh = in.readString();
        diaChi = in.readString();
        gioiTinh = in.readInt();
        truongYeuThich = in.readString();
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getNgaySinh() {
        return ngaySinh;
    }

    public void setNgaySinh(String ngaySinh) {
        this.ngaySinh = ngaySinh;
    }

    public String getDiaChi() {
        return diaChi;
    }

    public void setDiaChi(String diaChi) {
        this.diaChi = diaChi;
    }

    public int getGioiTinh() {
        return gioiTinh;
    }

    public void setGioiTinh(int gioiTinh) {
        this.gioiTinh = gioiTinh;
    }

    public String getTruongYeuThich() {
        return truongYeuThich;
    }

    public void setTruongYeuThich(String truongYeuThich) {
        this.truongYeuThich = truongYeuThich;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel parcel, int i) {
        parcel.writeInt(id);
        parcel.writeString(name);
        parcel.writeString(ngaySinh);
        parcel.writeString(diaChi);
        parcel.writeInt(gioiTinh);
        parcel.writeString(truongYeuThich);
    }
}
