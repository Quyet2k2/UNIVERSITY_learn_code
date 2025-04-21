package com.example.onclass._8_DanhBa_CSDL;

import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

public class C8_DanhBa implements Parcelable {
    public static final Creator<C8_DanhBa> CREATOR = new Creator<C8_DanhBa>() {
        @Override
        public C8_DanhBa createFromParcel(Parcel in) {
            return new C8_DanhBa(in);
        }

        @Override
        public C8_DanhBa[] newArray(int size) {
            return new C8_DanhBa[size];
        }
    };
    private int id;
    private String name;
    private int number;

    public C8_DanhBa(int id, String name, int number) {
        this.id = id;
        this.name = name;
        this.number = number;
    }

    public C8_DanhBa(String name, int number) {
        this.name = name;
        this.number = number;
    }

    protected C8_DanhBa(Parcel in) {
        name = in.readString();
        number = in.readInt();
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

    public int getNumber() {
        return number;
    }

    public void setNumber(int number) {
        this.number = number;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel parcel, int i) {
        parcel.writeString(name);
        parcel.writeInt(number);
    }
}
