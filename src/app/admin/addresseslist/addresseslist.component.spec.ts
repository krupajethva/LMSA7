import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddresseslistComponent } from './addresseslist.component';

describe('AddresseslistComponent', () => {
  let component: AddresseslistComponent;
  let fixture: ComponentFixture<AddresseslistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AddresseslistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddresseslistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
