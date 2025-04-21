package com.example.onclass._6_DanhBa_Menu_intent;

import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

public class C6_DanhBa implements Parcelable {

    public static final Creator<C6_DanhBa> CREATOR = new Creator<C6_DanhBa>() {
        @Override
        public C6_DanhBa createFromParcel(Parcel in) {
            return new C6_DanhBa(in);
        }

        @Override
        public C6_DanhBa[] newArray(int size) {
            return new C6_DanhBa[size];
        }
    };
    private String txtName, txtNumber;

    public C6_DanhBa(String txtName, String txtNumber) {
        this.txtName = txtName;
        this.txtNumber = txtNumber;
    }

    protected C6_DanhBa(Parcel in) {
        txtName = in.readString();
        txtNumber = in.readString();
    }

    public String getTxtName() {
        return txtName;
    }

    public void setTxtName(String txtName) {
        this.txtName = txtName;
    }

    public String getTxtNumber() {
        return txtNumber;
    }

    public void setTxtNumber(String txtNumber) {
        this.txtNumber = txtNumber;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel parcel, int i) {
        parcel.writeString(txtName);
        parcel.writeString(txtNumber);
    }
}
